<?php

namespace backend\modules\event\controllers;

use yii\web\Controller;
use yii;
use yii\web\Response;
use Da\QrCode\QrCode;
use Da\QrCode\Format\BookmarkFormat;
use backend\modules\event\models\Registration;
use backend\modules\event\models\Invitation; 
use yii2mod\rbac\filters\AccessControl;
/**
 * Default controller for the `event` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
   
    public function actionIndex($rg)
    {
        $this->layout = '@backend/views/layouts/main_register';
        $invitation=Invitation::find()->where(['registration_code'=>$rg])->one();
        
        if(!empty($invitation) && $invitation->event->register_deadline >= date('Y-m-d'))
        {
            $count_rg=\Yii::$app->db->createCommand('select count(id) from registration where invitation_id='.$invitation->id.'')->queryScalar();
            $registered=Registration::find()->where(['invitation_id'=>$invitation->id])->all();
            $model= new Registration();
            if ($model->load(Yii::$app->request->post()) && $count_rg < $invitation->pax) {
                $model->date=date('Y-m-d H:i:s');
                $model->code=sprintf("%06d", mt_rand(0, 999999));
                $model->invitation_id=$invitation->id;
                $model->org_name=$invitation->org_name1;
                if($model->save()){
                    return $this->render('success_rg',['invitation'=>$invitation]);
                }
            }
            return $this->render('index',['model'=>$model,'invitation'=>$invitation,'count_rg'=>$count_rg,'registered'=>$registered]);
        }else{
            if(!empty($invitation))
            {
                $errors=Yii::t('app','This registration already closed.<br/><br/>Thank you!');
            }else{
                $errors=Yii::t('app','The system not allow for you registration.<br/><br/>Please contact administrator!');
            }
            return $this->render('errer_rg',['error'=>$errors]);
        }
    }
}
