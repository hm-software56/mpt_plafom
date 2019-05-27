<?php

namespace backend\controllers;

use Yii;
use backend\models\Home;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * HomeController implements the CRUD actions for Home model.
 */
class HomeController extends Controller
{
    /**
     * {@inheritdoc}
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
        
        $this->layout = 'main_admin'; //your layout name
        return parent::beforeAction($action);
    }
    /**
     * Lists all Home models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Home::find()->localized(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Home model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Home model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Home();

        if ($model->load(Yii::$app->request->post())) {
            $photo_file = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo_file)) {
                $download_file_name = 'home_' . date('YmdHmsi') . '.' . $photo_file->extension;
                $photo_file->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name);
                $model->photo = $download_file_name;
            }
            if($model->save())
            {
                return $this->redirect(['index']);
            }
            
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Home model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Home::find()->multilingual()->where(['id' => $id])->one();
        $old_photo = $model->photo;

        if ($model->load(Yii::$app->request->post())) {
            $photo_file = UploadedFile::getInstance($model, 'photo');
            if (!empty($photo_file)) {
                $download_file_name = 'home_' . date('YmdHmsi') . '.' . $photo_file->extension;
                $photo_file->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name);
                $model->photo = $download_file_name;
                @unlink(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $old_photo);
            } else {
                    $model->photo = $old_photo;
            }
            if($model->save())
            {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Home model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Home model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Home the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Home::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
