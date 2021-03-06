<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/12/5
 * Time: 15:24
 */

namespace app\modules\mch\controllers\settlementbonus;


use app\models\YySetting;
use app\modules\mch\models\settlementbonus\Setting;

class NoticeController extends Controller
{
    public function actionSetting()
    {
        $setting = Setting::findOne(['store_id'=>$this->store->id]);
        if (!$setting){
            $setting = new Setting();
        }
        if (\Yii::$app->request->isPost){
            $model = \Yii::$app->request->post('model');
            if ($setting->isNewRecord){
                $setting->store_id = $this->store->id;
                $setting->cat = 0;
            }
            $setting->success_notice = $model['success_notice'];
            $setting->refund_notice  = $model['refund_notice'];
            if ($setting->save()){
                $this->renderJson([
                    'code'  => 0,
                    'msg'   => '保存成功',
                ]);
            }else{
                $this->renderJson([
                    'code'  => 0,
                    'msg'   => '保存失败，请重试',
                ]);
            }
        }
        return $this->render('setting',[
            'setting'  => $setting,
        ]);

    }
}