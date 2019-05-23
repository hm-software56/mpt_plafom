<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if (in_array($getuser->type, Yii::$app->params['type_user_register'])) {
            $this->layout = 'main_admin_register'; //your layout name
        }else{
            $this->layout = 'main_admin'; //your layout name
        }
        
        return parent::beforeAction($action);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if (in_array($getuser->type, Yii::$app->params['type_user_register'])) {
            return $this->redirect(['usermeeting']);
        }
        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUsermeeting()
    {
        $this->layout = 'main_admin_register'; //your layout name
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('usermeeting', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->created_at = date("Y-m-d");
        if ($model->load(Yii::$app->request->post())) {
            $password = $model->password;
            $model->setPassword($model->password);
            if ($model->save()) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($model->type);
                $auth->assign($role, $model->id);

                \Yii::$app->getSession()->setFlash('success', 'Creation successful.');
                return $this->redirect(['index']);
            } else {
                $model->password = $password;
                \Yii::$app->getSession()->setFlash('error', 'Creation failed. Please double check your inputs.');
                return $this->render('create', [
                        'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_password = $model->password;
        $old_type = $model->type;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->password != $old_password) {
                $model->setPassword($model->password);
            }
            if ($model->save()) {
                $auth = Yii::$app->authManager;
                $item = $auth->getRole($old_type);
                $auth->revoke($item, $model->id);

                $role = $auth->getRole($model->type);
                $auth->assign($role, $model->id);

                \Yii::$app->getSession()->setFlash('success', 'Update successful.');
                return $this->redirect(['index']);
            } else {
                $model->password = $old_password;
                \Yii::$app->getSession()->setFlash('error', 'Update failed. Please double check your inputs.');
                return $this->render('create', [
                        'model' => $model,
                ]);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
            \Yii::$app->getSession()->setFlash('error', "You can't delete this item because it is linked to another records. Please deactivate it instead of deleting.");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
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
            \Yii::$app->getSession()->setFlash('success', 'Activation successful.');
            return $this->redirect(['index']);
        } else {
            \Yii::$app->getSession()->setFlash('error', 'Activation failed.');
            return $this->redirect(['index']);
        }
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        $model->status = '0';
        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Deactivation successful.');
            return $this->redirect(['index']);
        } else {
            print_r($model->getErrors());
            exit;
            \Yii::$app->getSession()->setFlash('error', 'Deactivation failed.');
            return $this->redirect(['index']);
        }
        return $this->redirect(['index']);
    }

}
