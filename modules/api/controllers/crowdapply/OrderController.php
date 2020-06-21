<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/12/14
 * Time: 11:28
 */

namespace app\modules\api\controllers\crowdapply;


use app\models\Room;
use app\modules\api\models\crowdapply\Goods;
use app\modules\api\models\crowdapply\Order;
use app\modules\api\models\crowdapply\OrderForm;
use app\modules\api\models\crowdapply\OrderClerkForm;
use app\modules\api\models\crowdapply\OrderCommentForm;
use app\modules\api\models\crowdapply\OrderCommentPreview;
use app\modules\api\models\crowdapply\OrderListForm;
use app\modules\api\models\crowdapply\OrderPreviewFrom;
use app\modules\api\models\QrcodeForm;
use app\models\Shop;
use app\models\YyGoods;
use app\models\YyOrder;
use app\models\YyOrderForm;
use app\modules\api\behaviors\LoginBehavior;

class OrderController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }

    /**
     * 订单预览
     */
    public function actionSubmitPreview()
    {
        $form = new OrderPreviewFrom();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $form->goods_id = \Yii::$app->request->get('gid');
        $this->renderJson($form->search());
    }

    /**
     * 订单提交
     */
    public function actionSubmit()
    {
        $form = new OrderPreviewFrom();
        $model = \Yii::$app->request->post();
        $form->attributes = $model;
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $form->goods_id = $model['gid'];
        $form->form_list = json_decode($model['form_list'],true);
        $form->form_id = $model['form_id'];
        $this->renderJson($form->save());
    }

    /**
     * 订单列表
     */
    public function actionList()
    {
        $form = new OrderListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }


    /**
     * @param int $id
     * 用户取消
     */
    public function actionCancel($id = 0)
    {
        $order = Order::find()
            ->andWhere([
                'is_delete' => 0,
                'store_id' => $this->store->id,
                'user_id' => \Yii::$app->user->id,
                'is_cancel' => 0,
                'id' => $id,
            ])->one();

        if (!$order){
            $this->renderJson([
                'code'  => 1,
                'msg'   => '订单不存在，或已取消'
            ]);
        }

        $order->is_cancel = 1;

        //库存
        $goods = Goods::find()
            ->andWhere(['id'=>$order->goods_id,'is_delete'=>0,'status'=>1,'store_id'=>$this->store_id])->one();
        if (!$goods){
            return [
                'code'    => 1,
                'msg'     => '商品不存在',
            ];
        }
        $goods->stock ++;

        if ($goods->save() &&$order->save()){
            $this->renderJson([
                'code'  => 0,
                'msg'   => '取消成功'
            ]);
        }else{
            $this->renderJson([
                'code'  => 1,
                'msg'   => '取消失败'
            ]);
        }
    }

    /**
     * @param int $id
     * 订单列表支付按钮
     */
    public function actionPayData($id = 0){
        $form = new OrderPreviewFrom();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->payData($id));
    }

    /**
     * @param int $id
     * 订单详情
     */
    public function actionOrderDetails($id = 0)
    {
        $order = Order::find()
            ->alias('o')
            ->select([
                'o.*',
                'g.name','g.original_price','g.shop_id','g.cover_pic','g.id AS g_id'
            ])
            ->andWhere([
                'o.is_delete' => 0,
                'o.store_id' => $this->store->id,
                'o.user_id' => \Yii::$app->user->id,
                'o.is_cancel' => 0,
                'o.id' => $id,
            ])
            ->leftJoin(['g'=>Goods::tableName()],'g.id=o.goods_id')
            ->asArray()->one();
        if (!$order){
            $this->renderJson([
                'code'  => 1,
                'msg'   => '订单不存在，或已取消'
            ]);
        }

        $orderForm = OrderForm::find()
            ->andWhere(['store_id'=>$this->store->id,'order_id'=>$order['id']])
            ->select('key,value')
            ->asArray()
            ->all();
        $order['orderForm'] = $orderForm;


        $room_info='';
        $room_info =  Room::findOne(['room_id' => $order['room_id'], 'store_id' => $this->store_id ,'is_delete' =>0]);
        if($room_info){
            $room_info= $room_info->toArray();
        }
        $order['room_info']=$room_info;



        $shopList = [];
        if (!empty($order['shop_id'])){
            $shopId = explode(',',trim($order['shop_id'],','));
            $shopList = Shop::find()
                ->andWhere(['id'=>$shopId[0]])
                ->andWhere(['store_id'=>$this->store_id])
                ->asArray()
                ->all();
            $order['shopListNum'] = count($shopId);
        }else{
            $shopList = Shop::find()
                ->andWhere(['store_id'=>$this->store_id])
                ->asArray()
                ->limit(1)
                ->all();
            $shopListNum = Shop::find()
                ->andWhere(['store_id'=>$this->store_id])
                ->count();
            $order['shopListNum'] = $shopListNum;
        }

        $order['shopList'] = $shopList;
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        $this->renderJson([
           'code'   => 0,
           'msg'    => 'success',
           'data'   => $order
        ]);
    }

    /**
     * @param int $id
     * 核销订单详情
     */
    public function actionClerkOrderDetails($id = 0)
    {
        $order = Order::find()
            ->alias('o')
            ->select([
                'o.*',
                'g.name','g.original_price','g.shop_id','g.cover_pic','g.id AS g_id'
            ])
            ->andWhere([
                'o.is_delete' => 0,
                'o.store_id' => $this->store->id,
                'o.is_cancel' => 0,
                'o.id' => $id,
            ])
            ->leftJoin(['g'=>Goods::tableName()],'g.id=o.goods_id')
            ->asArray()->one();
        if (!$order){
            $this->renderJson([
                'code'  => 1,
                'msg'   => '订单不存在，或已取消'
            ]);
        }

        $orderForm = OrderForm::find()
            ->andWhere(['store_id'=>$this->store->id,'order_id'=>$order['id']])
            ->select('key,value')
            ->asArray()
            ->all();
        $order['orderForm'] = $orderForm;
        $shopList = [];
        if (!empty($order['shop_id'])){
            $shopId = explode(',',trim($order['shop_id'],','));
            $shopList = Shop::find()
                ->andWhere(['id'=>$shopId[0]])
                ->andWhere(['store_id'=>$this->store_id])
                ->asArray()
                ->all();
            $order['shopListNum'] = count($shopId);
        }else{
            $shopList = Shop::find()
                ->andWhere(['store_id'=>$this->store_id])
                ->asArray()
                ->limit(1)
                ->all();
            $shopListNum = Shop::find()
                ->andWhere(['store_id'=>$this->store_id])
                ->count();
            $order['shopListNum'] = $shopListNum;
        }

        $order['shopList'] = $shopList;
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        $this->renderJson([
            'code'   => 0,
            'msg'    => 'success',
            'data'   => $order
        ]);
    }


    /**
     * @return mixed|string
     * 核销订单二维码
     */
    public function actionGetQrcode()
    {

        $haibao = \Yii::$app->request->get('haibao');

        if(empty($haibao)){
            $this->renderJson([
                'code' => 0,
                'msg' => 'success',
                'data' => [
                    'url' => 'http://airent-hospital.oss-cn-beijing.aliyuncs.com/uploads/image/2d/2de65aa459924541f436dfdf510b5b2f.png',
                ],
            ]);
        }

        $order_no = \Yii::$app->request->get('order_no');
        $order = Order::findOne(['order_no'=>$order_no,'store_id'=>$this->store->id]);

        $form = new QrcodeForm();
        $form->data = [
            'scene'=>"{$order->id}",
            'page'=>"pages/crowdapply/order/order",
            'width'=>100
        ];
        $form->store = $this->store;
        $res = $form->getQrcode();

        return json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 核销订单
     */
    public function actionClerk()
    {
        $form = new OrderClerkForm();
        $form->order_id = \Yii::$app->request->get('order_id');
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }

    /**
     * 用户申请退款
     */
    public function actionApplyRefund()
    {
        $order_id = \Yii::$app->request->get('order_id');
        $order = Order::find()
            ->andWhere([
                'id'            => $order_id,
                'is_delete'     => 0,
                'store_id'      => $this->store->id,
                'user_id'       => \Yii::$app->user->id,
                'is_pay'        => 1,
                'is_refund'     => 0,
                'apply_delete'     => 0,
            ])
            ->one();
        if (!$order){
            $this->renderJson([
                'code'  => 1,
                'msg'   => '订单错误'
            ]);
        }
        if ($order->pay_price >= 0.01){
            $order->apply_delete = 1;
        }else{
            $order->apply_delete = 1;
            $order->is_refund = 1;
        }
        if ($order->save()){
            $this->renderJson([
                'code'  => 0,
                'msg'   => '退款申请成功',
            ]);
        }else{
            $this->renderJson([
                'code'  => 1,
                'msg'   => '退款申请失败,请重试'
            ]);
        }

    }

    /**
     * 评论预览页面
     */
    public function actionCommentPreview()
    {
        $form = new OrderCommentPreview();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    /**
     * 订单评论提交
     */
    public function actionComment()
    {
        $form = new OrderCommentForm();
        $form->attributes = \Yii::$app->request->post();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }




}