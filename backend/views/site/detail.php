<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

$link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $model->id;

$details = "";
$displayDet = "display:none !important;";
if ($contentCategory->has_details == 1) {
    $details = $model->details;
    $displayDet = "";
}
$displayDate = "display:none !important;";
$date = "";
if ($contentCategory->has_start_date == 1) {
    $displayDate = "";
    $date = date('d/m/Y', strtotime($model->start_date));
}
if ($contentCategory->has_end_date == 1) {
    $date = $date . " ~ " . date('d/m/Y', strtotime($model->end_date));
}
?>
<div class="divcontent">
    <p style="text-align: right;font-size:15px !important;<?php echo $displayDate ?>" class="black"><i class="fa fa-clock-o"></i> <?php echo $date; ?></p>
    <?php
    if (count($slides) > 0 && $contentCategory->has_multi_attachment == 1) {
        ?>
        <div class="camera_wrap camera_azure_skin wow fadeInDown" id="camera_wrap_1">
            <?php
//            if (isset($model->photo) && !empty($model->photo) && $contentCategory->has_photo == 1) {
//                $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo;
            ?>
    <!--                <div data-src="<?php //echo $photo;           ?>">
                </div>-->
            <?php
//            }
            foreach ($slides as $slide) {
                ?>
                <div data-src="<?php echo Yii::$app->urlManager->baseUrl . '/images/photolibrarys/' . $model->ref . "/" . $slide->real_filename; ?>">
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else if (isset($model->photo) && !empty($model->photo) && $contentCategory->has_photo == 1) {
        if (!in_array($model->id, [Yii::$app->params['idContentSidebar2'], Yii::$app->params['idContentSidebar3'], Yii::$app->params['idContentSidebar4'], Yii::$app->params['idContentSidebar5']])) {
            $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo;
            ?>
            <img alt="<?php echo $model->title ?>" src="<?php echo $photo; ?>" style="width:100%;margin-bottom: 15px;" class="img-responsive wow fadeInDown">
            <?php
        }
    }
    ?>


    <?php
    if (count($pdfs) > 0 && $contentCategory->has_multi_attachment == 1) {
        ?>
        <div style="clear:both;"></div><br/>
        <table class="table table-striped table-inverse table-bordered wow fadeInLeft" style="width:100%;">
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
                    $data = explode(".", $pdf->file_name);
                    $pdfurl = Yii::$app->urlManager->baseUrl . '/index.php?r=site/downloadfile&file=' . $model->ref . "/" . $pdf->real_filename;
                    if (strpos(strtolower($pdfurl), ".pdf") !== false) {
                        $icon = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params["iconPdf"];
                    } else {
                        $icon = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params["iconWord"];
                    }
                    ?>
                    <tr>
                        <td style="width:70%" scope="row"><?php echo $data[0]; ?></td>
                        <td style="width:30%"><a style="color:#5588D9;" href="<?php echo $pdfurl; ?>"><img src="<?php echo $icon ?>" style="width:20px;"/></a></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <div style="clear: both;"></div>
    <?php if ($displayDet != "display:none !important;") { ?>
        <div class="summarycontent"><p class="wow fadeInRight" style="<?php echo $displayDet ?>"><?php echo $details; ?></p></div>
        <?php } ?>
</div>