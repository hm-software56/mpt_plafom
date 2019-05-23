<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Admin Page');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <img src="<?php echo \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params["imgProject"]; ?>" style="width:100%;height: auto;"/>
    <div style="text-align: center;margin-top: 20px;">
        <p class="lead" style="font-size:15pt;font-weight: bold;"><?= Yii::t('app', "Welcome to Admin Page"); ?></p>
        <p style="font-size:13pt;"><?= Yii::t('app', "This page is only reserved for staff for updating the information about the web application."); ?></p>
    </div>
</div>
