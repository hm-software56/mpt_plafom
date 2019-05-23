<?php

namespace backend\controllers;

use Yii;
use backend\models\Content;
use backend\models\ContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii2mod\rbac\filters\AccessControl;
use backend\models\GallaryUploads;
use yii\helpers\BaseFileHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class ContentController extends Controller
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
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        $contentcategory = NULL;
        if (isset($type) && !empty($type)) {
            $contentcategory = \backend\models\ContentCategory::find()->localized()->where(['id' => $type])->one();
        }
        if (!isset($contentcategory)) {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Content Category is undefined'));
            return $this->redirect(['indexadmin']);
        }
        Yii::$app->session['type'] = $type;
        $searchModel = new ContentSearch();
        $searchModel->content_category_id = Yii::$app->session['type'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'contentcategory' => $contentcategory
        ]);
    }

    /**
     * Displays a single Content model.
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
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {

        $contentcategory = NULL;
        if (isset($type) && !empty($type)) {
            $contentcategory = \backend\models\ContentCategory::find()->localized()->where(['id' => $type])->one();
        }
        if (!isset($contentcategory)) {
            \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Content Category is undefined'));
            return $this->redirect(['indexadmin']);
        }
        Yii::$app->session['type'] = $type;
        $model = new Content();

        $model->status = '1';
        $model->start_date = date("Y-m-d");
        $model->end_date = date("Y-m-d");
        if ($contentcategory->has_photo == 1) {
            $model->scenario = 'create';
        }
        try {
            if ($model->load(Yii::$app->request->post())) {
// For gallary
                $this->Uploads(false);
//-------------------------------
                $photo = UploadedFile::getInstance($model, 'photo');
                if (!empty($photo)) {
                    $photo_name = "Content_" . date('YmdHmsi') . '.' . $photo->extension;
                    $photo->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $photo_name);
                    $model->photo = $photo_name;
                }
                if (isset(Yii::$app->user->id)) {
                    $model->created_by = Yii::$app->user->id;
                    $model->updated_by = Yii::$app->user->id;
                }
                $model->created_date = date("Y-m-d H:i:s");
                $model->updated_date = date("Y-m-d H:i:s");
                $model->content_category_id = Yii::$app->session['type'];

                if ($model->save()) {
                    \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Creation successful.'));
                    return $this->redirect(['index', 'type' => Yii::$app->session['type']]);
                } else {
                    \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Creation failed. Please double check your inputs.'));
                }
            } else {
// For gallary
                $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(), 10);
                Yii::$app->session['refImg'] = $model->ref;
            }
        } catch (yii\base\Exception $ex) {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', "Please click first on 'Upload' button."));
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
        return $this->render('create', [
                'model' => $model,
                'contentcategory' => $contentcategory
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        try {
            $model = Content::find()->multilingual()->where(['id' => $id])->one();
            $contentcategory = NULL;
            $type = $model->content_category_id;
            if (isset($type) && !empty($type)) {
                $contentcategory = \backend\models\ContentCategory::find()->localized()->where(['id' => $type])->one();
            }
            if (!isset($contentcategory)) {
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Content Category is undefined'));
                return $this->redirect(['indexadmin']);
            }
            Yii::$app->session['type'] = $type;
            $old_photo = $model->photo;


            if (empty($model->ref)) {
                $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(), 10);
            }
            Yii::$app->session['refImg'] = $model->ref;
            list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->ref);
            if ($model->load(Yii::$app->request->post())) {
                $photo = UploadedFile::getInstance($model, 'photo');

                $this->Uploads(false);
                if (!empty($photo)) {
                    $photo_name = "Content_" . date('YmdHmsi') . '.' . $photo->extension;
                    $photo->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $photo_name);
                    $model->photo = $photo_name;
                    @unlink(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $old_photo);
// For gallary image
                } else {
                    if ($model->remove_photo == 1) {
                        $model->photo = "";
                        @unlink(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $old_photo);
                    } else {
                        $model->photo = $old_photo;
                    }
                }
                if (isset(Yii::$app->user->id)) {
                    $model->updated_by = Yii::$app->user->id;
                }
                $model->updated_date = date("Y-m-d H:i:s");
                if ($model->save()) {
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Update successful.'));
                    return $this->redirect(['index', 'type' => Yii::$app->session['type']]);
                } else {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Update failed. Please double check your inputs.'));
                }
            }
        } catch (yii\base\Exception $ex) {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', "Please click first on 'Upload' button."));
            return $this->render('update', [
                    'model' => $model,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $initialPreviewConfig
            ]);
        }
        return $this->render('update', [
                'model' => $model,
                'initialPreview' => $initialPreview,
                'initialPreviewConfig' => $initialPreviewConfig,
                'contentcategory' => $contentcategory
        ]);
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $type = $model->content_category_id;
        Yii::$app->session['type'] = $type;
        try {
            if (!empty($model->ref)) {
                $this->removeUploadDir($model->ref);
                GallaryUploads::deleteAll(['ref' => $model->ref]);
            }
            $model->delete();
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Deletion Successful'));
            return $this->redirect(['index', 'type' => Yii::$app->session['type']]);
        } catch (\yii\db\IntegrityException $e) {
            return $this->redirect(['index', 'type' => Yii::$app->session['type']]);
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', "You can't delete this item because it is linked to another records. Please deactivate it instead of deleting."));
        }
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->status = '1';
        $model->save();

        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Activation successful.'));
            return $this->redirect(['index', 'type' => $model->content_category_id]);
        } else {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Activation failed.'));
            return $this->redirect(['index', 'type' => $model->content_category_id]);
        }
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        $model->status = '0';
        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Deactivation successful.'));
            return $this->redirect(['index', 'type' => $model->content_category_id]);
        } else {
            \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'Deactivation failed.'));
            return $this->redirect(['index']);
        }
        return $this->redirect(['index', 'type' => $model->content_category_id]);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /* |*********************************************************************************|
      |================================ Upload Ajax ====================================|
      |*********************************************************************************| */

    public function actionUploadAjax()
    {
        echo "sssssss";exit;
        $this->Uploads(true);
    }

    private function CreateDir($folderName)
    {
        if ($folderName != NULL) {
            $basePath = Content::getUploadPath();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
                BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    private function Uploads($isAjax = false)
    {
        if (Yii::$app->request->isPost) {

            $images = UploadedFile::getInstancesByName('upload_ajax');
            if ($images) {

                if ($isAjax === true) {
                    $ref = Yii::$app->request->post('ref');
                } else {
                    $GallaryUploads = Yii::$app->request->post('GallaryUploads');
                    $ref = $GallaryUploads['ref'];
                }
                if (empty($ref))
                    $ref = Yii::$app->session['refImg'];
                $this->CreateDir($ref);
                foreach ($images as $file) {
                    $fileName = $file->baseName . '.' . $file->extension;
                    $realFileName = md5($file->baseName . time()) . '.' . $file->extension;
                    $savePath = Content::UPLOAD_FOLDER . '/' . $ref . '/' . $realFileName;
//$savePath       = \Content::u.'/'.$ref.'/'. $realFileName;
                    if ($file->saveAs($savePath)) {

                        if ($this->isImage(Url::base(true) . '/' . $savePath)) {
                            $this->createThumbnail($ref, $realFileName);
                        }

                        $model = new GallaryUploads;
                        $model->ref = $ref;
                        $model->file_name = $fileName;
                        $model->real_filename = $realFileName;
                        $model->save();

                        if ($isAjax === true) {
                            echo json_encode(['success' => 'true']);
                        }
                    } else {
                        if ($isAjax === true) {
                            echo json_encode(['success' => 'false', 'eror' => $file->error]);
                        }
                    }
                }
            }
        }
    }

    private function getInitialPreview($ref)
    {
        $datas = GallaryUploads::find()->where(['ref' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview, $this->getTemplatePreview($value));
            array_push($initialPreviewConfig, [
                'caption' => $value->file_name,
                'width' => '120px',
                'url' => Url::to(['/content/deletefile-ajax']),
                'key' => $value->upload_id
            ]);
        }
        return [$initialPreview, $initialPreviewConfig];
    }

    public function isImage($filePath)
    {
        return @is_array(getimagesize($filePath)) ? true : false;
    }

    private function getTemplatePreview(GallaryUploads $model)
    {
        $filePath = Content::getUploadUrl() . $model->ref . '/thumbnail/' . $model->real_filename;
        $isImage = $this->isImage($filePath);
        if ($isImage) {
            $file = Html::img($filePath, ['class' => 'file-preview-image',
                    'alt' => $model->file_name, 'title' => $model->file_name]);
        } else {
            $file = "<div class = 'file-preview-other'> " .
                "<h2><i class = 'glyphicon glyphicon-file'></i></h2>" .
                "</div>";
        }
        return $file;
    }

    private function createThumbnail($folderName, $fileName, $width = 250)
    {
        $uploadPath = Content::getUploadPath() . '/' . $folderName . '/';
        $file = $uploadPath . $fileName;

        $image = Yii::$app->image->load($file);
        $image->resize($width);

        $image->save($uploadPath . 'thumbnail/' . $fileName);

        return;
    }

    public function actionDeletefileAjax()
    {

        $model = GallaryUploads::findOne(Yii::$app->request->post('key'));
        if ($model !== NULL) {
            $filename = Content::getUploadPath() . $model->ref . '/' . $model->real_filename;
            $thumbnail = Content::getUploadPath() . $model->ref . '/thumbnail/' . $model->real_filename;
            if ($model->delete()) {
                @unlink($filename);
                @unlink($thumbnail);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }

    private function removeUploadDir($dir)
    {
        BaseFileHelper::removeDirectory(Content::getUploadPath() . $dir);
    }

}
