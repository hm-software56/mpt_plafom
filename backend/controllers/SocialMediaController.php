<?php

namespace backend\controllers;

use Yii;
use backend\models\SocialMedia;
use backend\models\SocialMediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii2mod\rbac\filters\AccessControl;

/**
 * SocialMediaController implements the CRUD actions for SocialMedia model.
 */
class SocialMediaController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!isset(Yii::$app->session["currentUser"])) {
            $session = new \yii\web\Session;
            $session->open();
        }
        $user = \backend\models\User::findOne(['id' => \Yii::$app->user->id]);
        Yii::$app->session["currentUser"] = $user;

        $setting = \backend\models\Setting::findOne(Yii::$app->params["settingId"]);
        if (isset($setting)) {
            if (!isset(Yii::$app->session["setting"])) {
                $session = new \yii\web\Session;
                $session->open();
            }
            Yii::$app->session["setting"] = $setting;
        }
        $this->layout = 'main_admin'; //your layout name
        return parent::beforeAction($action);
    }

    /**
     * Lists all SocialMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SocialMediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SocialMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SocialMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SocialMedia();
        if ($model->load(Yii::$app->request->post())) {

            $photo_file = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo_file)) {
                $download_file_name = 'social_' . date('YmdHmsi') . '.' . $photo_file->extension;
                $photo_file->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name);
                $model->photo = $download_file_name;
            }

            if (isset(Yii::$app->user->id)) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
            }
            $model->created_date = date("Y-m-d H:i:s");
            $model->updated_date = date("Y-m-d H:i:s");
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Creation successful.'));
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SocialMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_photo = $model->photo;

        if ($model->load(Yii::$app->request->post())) {

            $photo_file = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo_file)) {
                $download_file_name = 'social_' . date('YmdHmsi') . '.' . $photo_file->extension;
                $photo_file->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name);
                $model->photo = $download_file_name;
                @unlink(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $old_photo);
            } else {
                if ($model->remove_photo == 1) {
                    $model->photo = "";
                    @unlink(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $old_doc);
                } else {
                    $model->photo = $old_photo;
                }
            }

            if (isset(Yii::$app->user->id)) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
            }
            $model->updated_date = date("Y-m-d H:i:s");

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $transaction->commit();
                    \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Update successful.'));
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SocialMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            \Yii::$app->getSession()->setFlash('success', 'Deletion Successful');
        } catch (\yii\db\IntegrityException $e) {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', "You can't delete this item because it is linked to another records. Please deactivate it instead of deleting."));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SocialMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SocialMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SocialMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->status = '1';
        $model->save();

        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Activation successful.'));
            return $this->redirect(['index']);
        } else {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Activation failed.'));
            return $this->redirect(['index']);
        }
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        $model->status = '0';
        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deactivation successful.'));
            return $this->redirect(['index']);
        } else {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Deactivation failed.'));
            return $this->redirect(['index']);
        }
    }

}
