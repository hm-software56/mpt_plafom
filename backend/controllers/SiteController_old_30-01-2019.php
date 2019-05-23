<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use backend\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function init()
    {
        parent::init();
        Yii::$app->language = (Yii::$app->language == 'en-US') ? Yii::$app->params["defaultLang"] : Yii::$app->language;
    }

    public function beforeAction($action)
    {
        if (!empty(\Yii::$app->user->id)) {
            $this->layout = 'main_admin'; //your layout name
        }
        return parent::beforeAction($action);
    }

    public function actionLanguage($lang)
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionIndex()
    {
        // Change it in the future
        $this->layout = 'main';
        return $this->render('index');
    }

    public function actionIndexadmin()
    {
        if (empty(\Yii::$app->user->id)) {
            return $this->redirect(['login']);
        }
        $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if(in_array($getuser->type,Yii::$app->params['type_user_register']))
        {
            return $this->redirect(['event/event']);
        }else{
            $this->layout = 'main_admin';
            return $this->render('indexadmin');
        }
        
    }

    public function randomPassword()
    {
        $charsUpppercas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charsLowercase = "abcdefghijklmnopqrstuvwxyz";
        $charsNumber = "0123456789";
        $charsSpecial = "!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($charsUpppercas), 0, 2) . substr(str_shuffle($charsNumber), 0, 3) . substr(str_shuffle($charsSpecial), 0, 2) . substr(str_shuffle($charsLowercase), 0, 2) . substr(str_shuffle($charsNumber), 0, 2);
        return str_shuffle($password);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'main_login';

        $model = new LoginForm();
        $model->scenario = 'login';
        $captcha = Yii::$app->request->post("captcha");
        $cv = $this->createAction('captcha');
        if ($model->load(Yii::$app->request->post()) && $cv->validate($captcha, true)) {
            if ($model->login()) {
                //return $this->goBack();
                $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
                if(in_array($getuser->type,Yii::$app->params['type_user_register']))
                {
                    return $this->redirect(['event/event']);
                }else{
                    return $this->redirect(['indexadmin']);
                }
                
            }
        }
        if (isset($_POST['captcha'])) {
            \Yii::$app->getSession()->setFlash('errorcaptcha', 'Code/Username/Password incorrect.');
        }
        return $this->render('login', [
                'model' => $model,
        ]);
    }

    public function actionForgetpassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'main_login';

        $model = new LoginForm();
        $captcha = Yii::$app->request->post("captcha");
        $cv = $this->createAction('captcha');
        if ($model->load(Yii::$app->request->post()) && $cv->validate($captcha, true)) {
            $user = \backend\models\User::find()->where(['username' => $model->username])->one();
            if (isset($user)) {
                $token = $user->password;
                $url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "");
                $url .= "://" . $_SERVER['HTTP_HOST'];
                $url .=Yii::$app->urlManager->baseUrl . "/index.php?r=site/resetpassword&email=" . $model->username . "&token=" . $token;

                Yii::$app->mailer->compose()
                    ->setFrom([Yii::$app->params["adminEmail"] => ""])
                    ->setTo($user->username)
                    ->setSubject(Yii::t('app', 'Resetting password'))
                    ->setHtmlBody(Yii::t('app', "<p>Dear User,<br/><br/>Please click on this link to confirm resetting your password:<br/> <a href='" . $url . "'>Reset</a><br/><br/>Thank you."))
                    ->send();
                \Yii::$app->getSession()->setFlash('success', 'Please check your email to reset your password.');
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('errorcaptcha', 'Username incorrect.');
            }
        } else if (isset($_POST['captcha'])) {
            \Yii::$app->getSession()->setFlash('errorcaptcha', 'Code/Username/Password incorrect.');
        }


        return $this->render('forgetpassword', [
                'model' => $model,
        ]);
    }

    public function actionResetpassword()
    {
        if (isset($_GET["email"]) && isset($_GET["token"])) {
            $user = \backend\models\User::find()->where(['username' => $_GET["email"], 'password' => $_GET["token"]])->one();
            if (isset($user)) {
                $password = $this->randomPassword();
                $user->setPassword($password);
                if ($user->save()) {
                    Yii::$app->mailer->compose()
                        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["nameProject"]])
                        ->setTo($user->username)
                        ->setSubject(Yii::t('app', 'New Account Information'))
                        ->setHtmlBody(Yii::t('app', "<p>Dear User,<br/><br/>Find below the information to login to your account:<br/><b>Username:</b>" . $user->username . "<br/><b>Password:</b>" . $password . "</p><br/><br/>Thank you."))
                        ->send();
                    \Yii::$app->getSession()->setFlash('success', 'Please check your email to get your new password.');
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Username incorrect.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionChangepassword()
    {
        if (isset(\Yii::$app->user->id)) {
            $model = \backend\models\User::find()->where(['id' => \Yii::$app->user->id])->one();
            $model->scenario = 'changepassword';
            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->getSecurity()->validatePassword($model->current_password, $model->password)) {
                    $model->setPassword($model->new_password);
                    $model->save();
                    \Yii::$app->getSession()->setFlash('success', 'Password change successful.');
                    Yii::$app->user->logout();
                    return $this->redirect(['login']);
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Please double check your inputs.');
                }
            }
            return $this->render('changepassword', ['model' => $model]);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionContents($id = "")
    {
        $this->layout = 'main';
        $verif = 0;
        $contentCategory = null;
        $typeDisplay = 0; // Use 0 to show one row ==>one item, 1 to show 1 row ==> 3 items, 2 to show in gridview
        $show_pdf = 0;
        $defaultPhoto = Yii::$app->params["defaultNewsPhoto"];
        if (isset($_GET["_pjax"])) {
            $_POST["submitbut"] = Yii::$app->session["submitbut"];
            $_POST["subject"] = Yii::$app->session["subject"];
            $_POST["content"] = Yii::$app->session["content"];
            $_POST["search"] = Yii::$app->session["search"];
            $_POST["id"] = Yii::$app->session["id"];
            $id = Yii::$app->session["id"];
        } else {
            $session = Yii::$app->session;
            if (!$session->isActive) {
                $session->open();
            }
            Yii::$app->session["id"] = $id;
            Yii::$app->session["display"] = "";
            Yii::$app->session["submitbut"] = "";
            Yii::$app->session["subject"] = "";
            Yii::$app->session["content"] = "";
            Yii::$app->session["search"] = "";
        }
        if (isset($id) && !empty($id)) {
            $id = (int) $id;
            $contentCategory = \backend\models\ContentCategory::find()->localized()->where(['id' => $id])->one();
            if (isset($contentCategory)) {
                $verif = 1;
            }
        }
        if ($verif == 1) {
            if ($contentCategory->is_legal_type == 1) {
                $typeDisplay = 2;
            }
            if (in_array($id, Yii::$app->params["idShowCol3"])) {
                $typeDisplay = 1;
            }

            if (Yii::$app->language == Yii::$app->params["multiSecondLang"]) {
                $subQuery = \backend\models\ContentTranslate::find()->where(['is not', 'title', NULL])->andWhere(['!=', 'title', ""])->andWhere(['=', 'language', Yii::$app->params["codeSecondLang"]])->select('content_id');
                if (isset($_POST["submitbut"])) {
                    if (isset($_POST["subject"]) && !isset($_POST["content"])) {
                        $subQuery->andWhere([ 'like', 'title', $_POST['search']]);
                    } else if (!isset($_POST["subject"]) && isset($_POST["content"])) {
                        $subQuery->andFilterWhere(['or', [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
                    } else {
                        $subQuery->andFilterWhere(['or', [ 'like', 'title', $_POST['search']], [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
                    }
                    Yii::$app->session["submitbut"] = isset($_POST["submitbut"]) ? $_POST["submitbut"] : "";
                    Yii::$app->session["subject"] = isset($_POST["subject"]) ? $_POST["subject"] : "";
                    Yii::$app->session["content"] = isset($_POST["content"]) ? $_POST["content"] : "";
                    Yii::$app->session["search"] = isset($_POST["search"]) ? $_POST["search"] : "";
                }
                $query = \backend\models\Content::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere(['content_category_id' => $id])->andWhere(['status' => 1]);
            } else {
                $query = \backend\models\Content::find()->localized(Yii::$app->language)->where(['status' => 1])->andWhere(['content_category_id' => $id]);
                if (isset($_POST["submitbut"])) {
                    if (isset($_POST["subject"]) && !isset($_POST["content"])) {
                        $query->andWhere([ 'like', 'title', $_POST['search']]);
                    } else if (!isset($_POST["subject"]) && isset($_POST["content"])) {
                        $query->andFilterWhere(['or', [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
                    } else {
                        $query->andFilterWhere(['or', [ 'like', 'title', $_POST['search']], [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
                    }
                    Yii::$app->session["submitbut"] = isset($_POST["submitbut"]) ? $_POST["submitbut"] : "";
                    Yii::$app->session["subject"] = isset($_POST["subject"]) ? $_POST["subject"] : "";
                    Yii::$app->session["content"] = isset($_POST["content"]) ? $_POST["content"] : "";
                    Yii::$app->session["search"] = isset($_POST["search"]) ? $_POST["search"] : "";
                }
            }
            $query = $query->orderBy(['start_date' => SORT_DESC, 'id' => SORT_DESC]);
            $countQuery = clone $query;
            $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params["maxContentsPage"]]);

            $models = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            if (isset($models) && isset($contentCategory)) {
                return $this->render('contents', [
                        'models' => $models,
                        'contentCategory' => $contentCategory,
                        'pagination' => $pagination,
                        'typeDisplay' => $typeDisplay,
                        'show_pdf' => $show_pdf,
                        'defaultPhoto' => $defaultPhoto,
                ]);
            }
        }
        if ($verif == 0) {
            return $this->redirect(['errorpage']);
        }
    }

    public function actionDetail($id)
    {
        $this->layout = 'main';
        $verif = 0;
        if (isset($id)) {
            $id = (int) $id;
            $model = null;
            if (Yii::$app->language == Yii::$app->params["multiSecondLang"]) {
                $subQuery = \backend\models\ContentTranslate::find()->where(['is not', 'title', NULL])->andWhere(['!=', 'title', ""])->andWhere(['=', 'language', Yii::$app->params["codeSecondLang"]])->select('content_id');
                $model = \backend\models\Content::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere(['status' => 1])->andWhere(['id' => $id])->one();
            } else {
                $model = \backend\models\Content::find()->localized(Yii::$app->language)->where(['status' => 1])->andWhere(['id' => $id])->one();
            }

            if (isset($model)) {
                $verif = 1;
                $pdfs = \backend\models\GallaryUploads::find()->where(['ref' => $model->ref])->andWhere(['or', ['like', 'real_filename', ".pdf"], [ 'like', 'real_filename', ".doc"]])->orderBy(['upload_id' => SORT_ASC])->all();
                $slides = \backend\models\GallaryUploads::find()->where(['ref' => $model->ref])->andWhere(['not like', 'real_filename', ".pdf"])->andWhere(['not like', 'real_filename', ".pdf"])->orderBy(['upload_id' => SORT_ASC])->all();
                return $this->render('detail', [
                        'model' => $model,
                        'contentCategory' => $model->contentCategory,
                        'slides' => $slides,
                        'pdfs' => $pdfs,
                ]);
            }
        }
        if ($verif == 0) {
            return $this->redirect(['errorpage']);
        }
    }

    public function actionDownload($file)
    {
         \Yii::$app->response->SendFile(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $file)->send();
    }

    public function actionDownloadfile($file)
    {
         \Yii::$app->response->SendFile(Yii::$app->basePath . '/web/images/photolibrarys/' . $file)->send();
    }

    public function actionIssue()
    {
        $model = new \backend\models\Issue();
        $model->scenario = "requiredCategory";
        $this->layout = 'main';
        $captcha = Yii::$app->request->post("captcha");
        $cv = $this->createAction('captcha');
        if ($model->load(Yii::$app->request->post()) && $cv->validate($captcha, true)) {
            $file_file = UploadedFile::getInstance($model, 'file');
            $name = "";
            if (!empty($file_file)) {
                $download_file_name = 'issue_' . date('YmdHmsi') . '.' . $file_file->extension;
                $name = 'images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name;
                $file_file->saveAs(Yii::$app->basePath . '/web/images/' . Yii::$app->params['downloadFilePath'] . "/" . $download_file_name);
                $model->file = $download_file_name;
            }
            $model->created_date = date("Y-m-d H:i:s");
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $transaction->commit();
                    $contentMail = Yii::t('app', "<p>Dear Member,<br/><br/>Find below the information about the issue:");
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Name: </b>") . $model->name;
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Email: </b>") . $model->email;
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Telephone: </b>") . $model->telephone;
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Issue Category: </b>") . $model->issueCategory->title;
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Subject: </b>") . $model->subject;
                    $contentMail = $contentMail . Yii::t('app', "<br/><b>Message: </b>") . $model->message;
                    if (!empty($model->file)) {
                        $url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "");
                        $url .= "://" . $_SERVER['HTTP_HOST'];
                        $url .= Yii::$app->urlManager->baseUrl . "/index.php?r=site/download&file=" . $model->file;

                        $contentMail = $contentMail . Yii::t('app', "<br/><b>Attached File: </b>") . $url;
                    }
                    $contentMail = $contentMail . Yii::t('app', "</p><br/><br/>Thank you.");

                    $mailSend = Yii::$app->mailer->compose()
                        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["nameProject"]])
                        ->setTo(Yii::$app->params["adminEmail"])
                        ->setSubject(Yii::t('app', 'New Issue'))
                        ->setHtmlBody($contentMail);

                    $mailSend->send();

                    \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Issue sent successfully.'));
                    return $this->redirect(['index']);
                } else {
                    \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Send issue failed.'));
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        } else {
            if (!$cv->validate($captcha, true) && isset($_POST["captcha"])) {
                \Yii::$app->getSession()->setFlash('errorcaptcha', 'Code/Username/Password incorrect.');
            }
            return $this->render('issue', [
                    'model' => $model,
            ]);
        }
    }

    public function actionContact()
    {
        $model = new \backend\models\Issue();
        $this->layout = 'main';
        $captcha = Yii::$app->request->post("captcha");
        $cv = $this->createAction('captcha');
        if ($model->load(Yii::$app->request->post()) && $cv->validate($captcha, true)) {
            $model->created_date = date("Y-m-d H:i:s");
            try {
                $contentMail = Yii::t('app', "<p>Dear Member,<br/><br/>Find below the information about the request:");
                $contentMail = $contentMail . Yii::t('app', "<br/><b>Name: </b>") . $model->name;
                $contentMail = $contentMail . Yii::t('app', "<br/><b>Email: </b>") . $model->email;
                $contentMail = $contentMail . Yii::t('app', "<br/><b>Telephone: </b>") . $model->telephone;
                $contentMail = $contentMail . Yii::t('app', "<br/><b>Subject: </b>") . $model->subject;
                $contentMail = $contentMail . Yii::t('app', "<br/><b>Message: </b>") . $model->message;

                $contentMail = $contentMail . Yii::t('app', "</p><br/><br/>Thank you.");

                $mailSend = Yii::$app->mailer->compose()
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["nameProject"]])
                    ->setTo(Yii::$app->params["adminEmail"])
                    ->setSubject(Yii::t('app', 'New Request'))
                    ->setHtmlBody($contentMail);

                $mailSend->send();

                \Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Request sent successfully.'));
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                \Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Request sent failed.'));
            }
        } else {
            if (!$cv->validate($captcha, true) && isset($_POST["captcha"])) {
                \Yii::$app->getSession()->setFlash('errorcaptcha', 'Code/Username/Password incorrect.');
            }
            return $this->render('contact', [
                    'model' => $model,
            ]);
        }
    }

    public function actionSearch()
    {
        $this->layout = 'main';
        if (!isset($_POST['search'])) {
            $session = Yii::$app->session;
            $_POST['search'] = $session['search'];
        } else {
            $session = Yii::$app->session;
            if (!$session->isActive) {
                $session->open();
            }
            if (!isset($_POST['search'])) {
                $_POST['search'] = "";
            }
            $session['search'] = $_POST['search'];
        }

        if (!isset($_POST['content_category_id'])) {
            $session = Yii::$app->session;
            $_POST['content_category_id'] = $session['content_category_id'];
        } else {
            $session = Yii::$app->session;
            if (!$session->isActive) {
                $session->open();
            }
            if (!isset($_POST['content_category_id'])) {
                $_POST['content_category_id'] = "";
            }
            $session['content_category_id'] = $_POST['content_category_id'];
        }

        if (Yii::$app->language == Yii::$app->params["multiSecondLang"]) {
            $subQuery = \backend\models\ContentTranslate::find()->where(['is not', 'title', NULL])->andWhere(['!=', 'title', ""])->andWhere(['=', 'language', Yii::$app->params["codeSecondLang"]])->select('content_id');

            $subQuery->andFilterWhere(['or', [ 'like', 'title', $_POST['search']], [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
            if (!empty($_POST['content_category_id'])) {
                $query1 = \backend\models\Content::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere(['content_category_id' => $_POST['content_category_id']])->andWhere(['status' => 1]);
            } else {
                $query1 = \backend\models\Content::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere(['status' => 1]);
            }
        } else {
            $query1 = \backend\models\Content::find()->localized(Yii::$app->language)->where(['status' => 1]);
            if (!empty($_POST['content_category_id'])) {
                $query1->andFilterWhere(['or', [ 'like', 'title', $_POST['search']], [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]])->andWhere(['content_category_id' => $_POST['content_category_id']]);
            } else {
                $query1->andFilterWhere(['or', [ 'like', 'title', $_POST['search']], [ 'like', 'summary', $_POST['search']], [ 'like', 'details', $_POST['search']]]);
            }
        }

        $query1 = $query1->orderBy(['content_category_id' => SORT_ASC, 'start_date' => SORT_DESC, 'id' => SORT_DESC]);
        $countQuery1 = clone $query1;
        $pages1 = new Pagination(['totalCount' => $countQuery1->count(), 'pageSize' => 10, 'pageParam' => 'search-page',]);

        $results = $query1->offset($pages1->offset)
            ->limit($pages1->limit)
            ->all();

        return $this->render('search', [
                'results' => $results,
                'pages' => $pages1
        ]);
    }

    public function actionDetailslide($id)
    {
        $this->layout = 'main';
        $verif = 0;
        if (isset($id)) {
            if (Yii::$app->language == Yii::$app->params["multiSecondLang"]) {
                $subQuery = \backend\models\SliderTranslate::find()->where(['is not', 'title', NULL])->andWhere([ '!=', 'title', ""])->andWhere([ '=', 'language', Yii::$app->params["multiSecondLang"]])->select('slider_id');
                $model = \backend\models\Slider::find()->localized(Yii::$app->language)->where(['in', 'id', $subQuery])->andWhere([ 'id' => $id])->one();
            } else {
                $model = \backend\models\Slider::find()->localized(Yii::$app->language)->where(['id' => $id])->one();
            }
            if (isset($model)) {
                return $this->render('detailslide', [
                        'model' => $model
                ]);
            }
        }

        return $this->redirect(['error']);
    }

}
