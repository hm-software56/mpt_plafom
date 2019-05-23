<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\GallaryUploads;
use yii\helpers\Url;

$this->title = Yii::t('app', 'View') . " " . $model->contentCategory->title;
$this->params['breadcrumbs'][] = ['label' => $model->contentCategory->title, 'url' => ['index', 'type' => $model->contentCategory->id]];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'View');
?>
<div class="content-view">
    <a href="../site/detail.php"></a>
    <?php $url = \Yii::$app->request->BaseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo; ?>
    <?php
    $label = Yii::t("app", "Start Date");
    if ($model->contentCategory->has_start_date) {
        if (!$model->contentCategory->has_end_date) {
            $label = Yii::t("app", "Date");
        }
    }
    ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => Html::img($url, ['title' => $model->title, 'class' => 'img-responsive img-fluid']),
                'visible' => ($model->contentCategory->has_photo) ? TRUE : FALSE,
            ],
            'title',
            [
                'attribute' => 'start_date',
                'label' => $label,
                'value' => isset($model->start_date) ? date('d/m/Y', strtotime($model->start_date)) : "",
                'visible' => ($model->contentCategory->has_start_date) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'end_date',
                'value' => isset($model->end_date) ? date('d/m/Y', strtotime($model->end_date)) : "",
                'visible' => ($model->contentCategory->has_end_date) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'summary',
                'format' => 'ntext',
                'value' => $model->summary,
                'visible' => ($model->contentCategory->has_summary) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'details',
                'format' => 'html',
                'value' => $model->details,
                'visible' => ($model->contentCategory->has_details) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'keywords',
                'format' => 'ntext',
                'visible' => ($model->contentCategory->has_keywords) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'meta_keywords',
                'format' => 'ntext',
                'visible' => ($model->contentCategory->has_meta_keywords) ? TRUE : FALSE,
            ],
            [
                'attribute' => 'status',
                'value' => $model->status == 0 ? Yii::t("app", "Inactive") : Yii::t("app", "Active"),
            ],
            [
                'attribute' => 'created_date',
                'value' => isset($model->created_date) ? date('d/m/Y H:i:s', strtotime($model->created_date)) : "",
            ],
            [
                'attribute' => 'created_by',
                'value' => isset($model->created_by) ? $model->createdBy->full_name : "",
            ],
            [
                'attribute' => 'updated_date',
                'value' => isset($model->updated_date) ? date('d/m/Y H:i:s', strtotime($model->updated_date)) : "",
            ],
            [
                'attribute' => 'updated_by',
                'value' => isset($model->updated_by) ? $model->updatedBy->full_name : "",
            ],
        ],
    ])
    ?>
    <?php $dat = $model->getThumbnails($model->ref, $model->title); ?>
    <?php if (count($dat) > 0 && $model->contentCategory->has_multi_attachment) { ?><br/><br/>
        <div class="panel panel-default">
            <div class="panel-body">
                <?= dosamigos\gallery\Gallery::widget(['items' => $model->getThumbnails($model->ref, $model->title)]); ?>
                <?php
                $pdfs = \backend\models\GallaryUploads::find()->where(['ref' => $model->ref])->andWhere(['or', ['like', 'real_filename', ".pdf"], [ 'like', 'real_filename', ".doc"]])->orderBy(['upload_id' => SORT_ASC])->all();
                if (count($pdfs) > 0 && $model->contentCategory->has_multi_attachment == 1) {
                    ?>
                    <div style="clear:both;"></div><br/>
                    <table class="table table-striped table-inverse table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:70%" colspan="2"><?php echo Yii::t('app', "Attachment(s):") ?></th>
                            </tr>
                            <tr>
                                <th style="width:70%"><?php echo Yii::t('app', "Title"); ?></th>
                                <th style="width:30%"><?php echo Yii::t('app', "Downlaod"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pdfs as $pdf) {
                                $pdfurl = Yii::$app->urlManager->baseUrl . '/index.php?r=site/downloadfile&file=' . $model->ref . "/" . $pdf->real_filename;
                                if (strpos(strtolower($pdfurl), ".pdf") !== false) {
                                    $icon = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params["iconPdf"];
                                } else {
                                    $icon = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params["iconWord"];
                                }
                                ?>
                                <tr>
                                    <td style="width:70%" scope="row"><?php echo $pdf->file_name; ?></td>
                                    <td style="width:30%"><a style="color:#5588D9;" href="<?php echo $pdfurl; ?>"><img src="<?php echo $icon ?>" style="width:20px;"/></a></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php } ?>

    <br/>
</div>

