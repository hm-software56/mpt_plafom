<?php

namespace backend\controllers;

use Yii;
use backend\models\IssueCategory;
use backend\models\IssueCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

/**
 * IssueCategoryController implements the CRUD actions for IssueCategory model.
 */
class IssueCategoryController extends Controller
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
     * Lists all IssueCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IssueCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IssueCategory model.
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
     * Creates a new IssueCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IssueCategory();

        if ($model->load(Yii::$app->request->post())) {
            if (isset(Yii::$app->user->id)) {
                $model->created_by = Yii::$app->user->id;
                $model->updated_by = Yii::$app->user->id;
            }
            $model->created_date = date("Y-m-d H:i:s");
            $model->updated_date = date("Y-m-d H:i:s");
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Creation successful.'));
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Creation failed. Please double check your inputs.'));
            }
        }
        return $this->render('create', [
                'model' => $model,
        ]);
    }

    /**
     * Updates an existing IssueCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = IssueCategory::find()->multilingual()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post())) {
            if (isset(Yii::$app->user->id)) {
                $model->updated_by = Yii::$app->user->id;
            }
            $model->updated_date = date("Y-m-d H:i:s");
            if ($model->save()) {
                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Update successful.'));
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Update failed. Please double check your inputs.'));
            }
        }
        return $this->render('update', [
                'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IssueCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deletion Successful'));
        } catch (\yii\db\IntegrityException $e) {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', "You can't delete this item because it is linked to another records. Please deactivate it instead of deleting."));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the IssueCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IssueCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IssueCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
