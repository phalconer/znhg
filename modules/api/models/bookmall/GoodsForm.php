<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/8/15
 * Time: 9:56
 */

namespace app\modules\api\models\bookmall;

use app\extensions\getInfo;
use app\models\Favorite;
use app\modules\api\models\Model;

class GoodsForm extends Model
{
    public $id;
    public $user_id;
    public $store_id;

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id'], 'safe'],
        ];
    }

    /**
     * 排序类型$sort   1--综合排序 2--销量排序
     */
    public function search()
    {
        if (!$this->validate())
            return $this->getModelError();
        $goods = Goods::findOne([
            'id' => $this->id,
            'is_delete' => 0,
            'status' => 1,
            'store_id' => $this->store_id,
        ]);
        if (!$goods)
            return [
                'code' => 1,
                'msg' => '商品不存在或已下架',
            ];
        $pic_list = GoodsPic::find()->select('pic_url')->where(['goods_id' => $goods->id, 'is_delete' => 0])->asArray()->all();
        $is_favorite = 0;
        if ($this->user_id) {
            $exist_favorite = Favorite::find()->where(['user_id' => $this->user_id, 'goods_id' => $goods->id, 'is_delete' => 0])->exists();
            if ($exist_favorite)
                $is_favorite = 1;
        }
        $service_list = explode(',', $goods->service);
        $new_service_list = [];
        if (is_array($service_list))
            foreach ($service_list as $item) {
                $item = trim($item);
                if ($item)
                    $new_service_list[] = $item;
            }
        $res_url = getInfo::getVideoInfo($goods->video_url);
        $goods->video_url = $res_url['url'];




        $seckill_data = $this->getSeckillData($goods->id);

        if (!$seckill_data){
            return [
                'code' => 1,
                'msg' => '整点预售结束',
            ];
        }


        //查询当前总共订单量
        $query_num_buy_order = Order::find()->alias('o')
            ->where(
                [
                    'od.goods_id' => $goods->id,
                    'o.is_delete' => 0,
                    'o.store_id' => $this->store_id])
            ->leftJoin(['od' => OrderDetail::tableName()], 'od.order_id=o.id')
            ->andWhere([
                'AND',
                [
                    'od.is_delete' => 0,
                    'o.is_delete' => 0,
                    'o.is_pay' => 1,
//                        'o.is_check_yukuan' => 0,//还未审核到
                    'o.is_yukuan' => 0//未支付余款的
                ],
            ])->count();
//            $num = $seckill_data['sell_num'];
        $num = $query_num_buy_order;
        $charge_coupon = 0;
        $charge_integral_buy = 0;

        if ($goods->is_buy_integral_down) {
            $charge_integral_buy = $this->getCharge($num, $goods)['charge'];
        }

        if ($goods->is_coupon_down) {
            $charge_coupon = $this->getCharge($num, $goods)['charge'];
        }
        if ($seckill_data !== false) {
            $next_coupon = intval($seckill_data['seckill_coupon'] * (1 - $charge_coupon / 100));
            $next_integral_buy = intval($seckill_data['seckill_integral_buy'] * (1 - $charge_integral_buy / 100));
            $next_num = intval($this->getCharge($num, $goods)['nextnum']);
        }
        $seckill_data['next']=array(
             'next_coupon'=>$next_coupon,
             'next_integral_buy'=>$next_integral_buy,
             'next_num'=>$next_num,
        );
        $seckill_data['sell_num']=$num;


        return [
            'code' => 0,
            'data' => (object)[
                'id' => $goods->id,
                'pic_list' => $pic_list,
                'name' => $goods->name,
                'price' => floatval($goods->price),
                'detail' => $goods->detail,
                'sales_volume' => $goods->getSalesVolume() + $goods->virtual_sales,
                'attr_group_list' => $goods->getAttrGroupList(),
                'num' => $goods->getNum(),
                'is_favorite' => $is_favorite,
                'service_list' => $new_service_list,
                'original_price' => floatval($goods->original_price),
                'video_url' => $goods->video_url,
                'unit' => $goods->unit,
                'seckill' => $seckill_data,
                'use_attr' => intval($goods->use_attr),
                'coupon' => intval($goods->coupon),
                'integral_buy' => intval($goods->integral_buy),
            ],
        ];
    }

    //获取商品秒杀数据
    public function getSeckillData($goods_id)
    {
        $seckill_goods = SeckillGoods::findOne([
            'goods_id' => $goods_id,
            'is_delete' => 0,
            'start_time' => intval(date('H')),
            'open_date' => date('Y-m-d'),
        ]);
        if (!$seckill_goods)
            return null;
        $attr_data = json_decode($seckill_goods->attr, true);
        $total_seckill_num = 0;
        $total_sell_num = 0;
        $seckill_price = 0.00;
        $seckill_coupon = 0;
        $seckill_integral_buy = 0;
        foreach ($attr_data as $i => $attr_data_item) {
            $total_seckill_num += $attr_data_item['seckill_num'];
            $total_sell_num += $attr_data_item['sell_num'];
            if ($seckill_price == 0) {
                $seckill_price = $attr_data_item['seckill_price'];
                $seckill_coupon = $attr_data_item['seckill_coupon'];
                $seckill_integral_buy = $attr_data_item['seckill_price'];
            } else {
                $seckill_price = min($seckill_price, $attr_data_item['seckill_price']);
                $seckill_coupon = min($seckill_coupon, $attr_data_item['seckill_coupon']);
                $seckill_integral_buy = min($seckill_integral_buy, $attr_data_item['seckill_price']);
            }
        }
        return [
            'seckill_coupon' => $seckill_coupon,
            'seckill_integral_buy' => $seckill_integral_buy,
            'seckill_num' => $total_seckill_num,
            'sell_num' => $total_sell_num,
            'seckill_price' => (float)$seckill_price,
            'begin_time' => strtotime($seckill_goods->open_date . ' ' . $seckill_goods->start_time . ':00:00'),
            'end_time' => strtotime($seckill_goods->open_date . ' ' . $seckill_goods->start_time . ':59:59'),
            'now_time' => time(),
        ];
    }

    public function getCharge($num, $goods)
    {
        $charge = 0;
        $nextnum=0;

        if ($num <= $goods->chargeNum && $num > 0) {
            $charge = $goods->charge;  //1张
            $nextnum=$goods->chargeNum1;
        } elseif ($num <= $goods->chargeNum1 && $num > $goods->chargeNum) {
            $charge = $goods->charge1; //1-6
            $nextnum=$goods->chargeNum2;
        } elseif ($num <= $goods->chargeNum2 && $num > $goods->chargeNum1) {
            $charge = $goods->charge2;//7-18
            $nextnum=$goods->chargeNum3;
        } elseif ($num <= $goods->chargeNum3 && $num > $goods->chargeNum2) {
            $charge = $goods->charge3; //18以上
            $nextnum=$goods->chargeNum3;
        }elseif($num == 0) {
            $charge = 0;  //1张
            $nextnum=$goods->chargeNum;
        } else {
            $charge = $goods->charge5;  //1张
            $nextnum=$goods->chargeNum3;
        }

        $date=array(
            'charge'=>$charge,
            'nextnum'=>$nextnum,
        );

        return $date;
    }
}