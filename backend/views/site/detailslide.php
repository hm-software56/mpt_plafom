<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

if (isset($model->photo) && !empty($model->photo)) {
    $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo;
} else {
    $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . Yii::$app->params['defaultNewsPhoto'];
}
?>
<div class="divcontent">
    <article class="aa-latest-blog-single wow fadeInLeft">
        <figure class="aa-blog-img" style="height: auto;">
            <img alt="<?php echo $model->title ?>" src="<?php echo $photo; ?>" class="img-responsive">
        </figure>
        <div class="aa-blog-info wow fadeInRight">
            <br/>
            <p class="summarycontent"><?php echo $model->details; ?></p>
        </div>
    </article>
</div>


