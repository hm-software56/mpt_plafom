<?php

namespace backend\modules\event\controllers;

use Yii;
use backend\modules\event\models\Event;
use backend\modules\event\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\event\models\Invitation;
use Da\QrCode\QrCode;
use Da\QrCode\Format\BookMarkFormat; 
use yii2mod\rbac\filters\AccessControl;
use yii\helpers\Url;
use backend\modules\event\models\Registration;
/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $invitionlist = Invitation::find()->where(['event_id'=>$id])->orderBy('id DESC')->all();
        return $this->render('view', [
            'model' => $model,
            'invitationlist'=>$invitionlist
        ]);
    }

    public function actionViewprint($id)
    {
        
        $invitionlist = Invitation::find()->where(['id'=>$id])->orderBy('id DESC')->one();
        $model=$this->findModel($invitionlist->event_id);
        return $this->render('viewprint', [
            'model' => $model,
            'list'=>$invitionlist
        ]);
    }

    public function actionInvitcreate($rg_id)
    {
        $invition = new Invitation();
        $model=$this->findModel($rg_id);
        if ($invition->load(Yii::$app->request->post())) {
            $invition->registration_code=''.time().'';
            $invition->event_id=$model->id;
            if($invition->save()){
                $url=Url::base(true)."/index.php?r=event/default/index&rg=$invition->registration_code";
                $format = new BookMarkFormat(
                    ['title' => 'ລະ​ຫັດ:'.$invition->registration_code.'
ໝົດ​ກຳ​ນົດ​ລົງ​ທະ​ບຽນ​ວັນ​ທີ '.$model->register_deadline.'
ກົດ​ລີງ​ເຂົ້າ​ລົງ​ທະ​ບຽນ',
                     'url' =>$url
                     ]);
                $qrCode = (new QrCode($format))
                ->setSize(250)
                ->setMargin(5)
                ->useForegroundColor(51, 153, 255)
                ->setLabel('MPT');
                $a= $qrCode->writeString();
                file_put_contents(Yii::$app->basePath.'/web/imgqrcode/'.$invition->registration_code.'.png', $a);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            print_r($invition->getErrors());
        }else{
            return $this->renderAjax('invit_modal',['invitation'=>$invition,'rg_id'=>$rg_id]);
        }
    }
    public function actionInvitedit($id)
    {
        $model = Invitation::find()->where(['id'=>$id])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->event_id]);
        } else {
            return $this->renderAjax('invit_modal',['invitation'=>$model,]);
        }
    }
    public function actionInvitdelete($id)
    {
        $model = Invitation::find()->where(['id'=>$id])->one();
        $rg_id=$model->event_id;
        if($model->delete()) {
            return $this->redirect(['view', 'id' =>$rg_id]);
        }
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionListregistered($id){
        $model=Registration::find()->joinWith(['invitation.event as event'])->where(['event.id'=>$id])->all();
        $event=Event::find()->where(['id'=>$id])->one();
        return $this->render('listregistered',['model'=>$model,'event'=>$event]);
    }

    public function actionExportlistregistered($id)
    {
        $model=Registration::find()->joinWith(['invitation.event as event'])->where(['event.id'=>$id])->all();
        \moonland\phpexcel\Excel::export([
            'models' => $model, 
            'columns' => ['first_name','last_name','gender','position','org_name','telephone','email'], //without header working, because the header will be get label from attribute label. 
           // 'headers' => ['first_name' =>Yii::t('app','First Name'),'last_name' => Yii::t('app','Last Name'), 'gender' => Yii::t('app','Gender')],
        ]);
    }
}
