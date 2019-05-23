<?php

use yii\widgets\LinkPager;
use yii\data\Pagination;
use yii\widgets\Pjax;

if (!isset($notshowtitle)) {
    $this->title = $contentCategory->title;
    $this->params['breadcrumbs'][] = $this->title;
}
?>

<div class="divcontent">
    <?php if (!isset($notshowtitle)) { ?>
        <fieldset class = "scheduler-border">
            <legend class = "scheduler-border"><?= Yii::t('app', 'Search in current page') ?></legend>
            <form method="post" role="search" action="" class="wow1 fadeInRight1">
                <p style="<?= Yii::$app->session["display"] ?>"><input type="checkbox" name="subject" <?= (Yii::$app->session["subject"] != "") ? "checked" : ""; ?>/>&nbsp;<strong><?php echo Yii::t("app", "Title"); ?></strong>
                    <input style="margin-left: 20px;" type="checkbox" name="content" <?= (Yii::$app->session["content"] != "") ? "checked" : ""; ?>/>&nbsp;<strong><?php echo Yii::t("app", "Content"); ?></strong></p>
                <input type="text" name="search" id="" placeholder="<?php echo Yii::t("app", "Search") ?>" class="form-control input-search" style="width: 70%;" value="<?= (Yii::$app->session["search"] != "") ? Yii::$app->session["search"] : ""; ?>">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                <button type="submit" class="btn-search" name="submitbut" style="float:left;width:20px !important"><span class="fa fa-search"></span></button>
            </form>
            <div style="clear:both;"></div><br/>
        </fieldset>
    <?php } ?>
    <div style="clear:both;"></div>
    <?php //Pjax::begin(['id' => "contents", 'timeout' => Yii::$app->params['pajax_timeout']]); ?>
    <?php
    if (count($models) == 0) {
        ?>
        <div style="width:100% !important;text-align:center !important;margin:0 auto !important;"><p style="text-align:center !important;margin:0 auto !important;font-weight: bold !important;"><?php echo Yii::t('app', "There are no contents for that section.") ?></p><br/><br/></div>
        <?php
    } else {
        $i = 0;
        foreach ($models as $model) {
            $i++;
            $link = "#";
            if ($contentCategory->has_details == 1) {
                $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $model->id;
            }

            $photo = "";
            $defaultNewsPhoto = Yii::$app->params['defaultNewsPhoto'];
            if (isset($model->photo) && !empty($model->photo)) {
                $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo;
            } else if (isset($defaultNewsPhoto)) {
                $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $defaultNewsPhoto;
            }
            $summary = "";
            $displaySum = "display:none !important;";
            if ($contentCategory->has_summary == 1) {
                $summary = $model->summary;
                $displaySum = "";
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
            $displayMore = "";
            if ($contentCategory->has_details == 0) {
                //$link = "#";
                $displayMore = "display:none !important;";
            }
            if (!empty($photo)) {
                $classRight = "divright";
            } else {
                $classRight = "fullwidth";
            }
            $delay = "." . ($i * 2) . "s";
            $classFade = "fadeInLeft1";
            if (($i % 3) == 0) {
                $classFade = "fadeInRight1";
            }
            ?>
            <?php if ($typeDisplay == 0) { ?>
                <div class="oneitem wow1 <?= $classFade ?>">
                    <?php if ($contentCategory->has_photo == 1 && !empty($photo)) { ?>
                        <div class="divleft">
                            <a href="<?php echo $link; ?>"><img alt="<?php echo $model->title ?>" src="<?php echo $photo; ?>" style="width:100%;margin-bottom: 15px;"></a>
                        </div>
                    <?php } ?>
                    <div class="<?= $classRight ?>">
                        <h4><a class="feat-title" href="<?php echo $link; ?>"><?php echo $model->title; ?></a></h4>
                        <p style="text-align: left;<?php echo $displayDate ?>" class="black"><i class="fa fa-clock-o"></i> <?php echo $date; ?></p>

                        <p class="summarycontent" style="<?php echo $displaySum ?>"><?php echo $summary; ?></p>
                        <a class="blog-more-btn black" style="float:right;<?php echo $displayMore ?>" href="<?php echo $link; ?>">
                        <?php
                        if(in_array((int)$_GET['id'],Yii::$app->params['Id_change_readmore_to_download']))
                        {
                            echo Yii::t('app', "Download");
                        }else{
                         echo Yii::t('app', "Read more");
                        }
                         ?>
                         <i class="fa fa-long-arrow-right"></i></a>
                        <p>&nbsp;</p>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <div class="dotted"></div>
                <?php
            } else if ($typeDisplay == 1) {
                $classheight = "heighttwo";
                ?>
                <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 specmargcontent wow1 bounceIn">
                    <article class="aa-latest-blog-single">
                        <figure class="aa-blog-img wow1 fadeInLeft1 <?= $classheight ?>">
                            <a href="<?php echo $link; ?>"><img alt="<?php echo $model->title ?>" src="<?php echo $photo; ?>" class="img-responsive"></a>
                            <?php if (empty($displayDate)) { ?>
                                <figcaption class="aa-blog-img-caption" style="text-align:left !important;">
                                    <p style="text-align: left;<?php echo $displayDate ?>" class="black"><i class="fa fa-clock-o"></i> <?php echo $date; ?></p>
                                </figcaption>
                            <?php } ?>
                        </figure>
                        <div class="aa-blog-info wow1 fadeInRight1">
                            <h3 class="aa-blog-title"><a class="feat-title" href="<?php echo $link; ?>"><?php echo $model->title; ?>
                                    <?php
                                    $short = mb_substr($model->title, 0, Yii::$app->params["maxCharactersTitle"], mb_detect_encoding($model->title));
                                    if ($short != $model->title) {
                                        echo $short . "...";
                                    } else {
                                        echo $model->title;
                                    }
                                    ?></a></h3>
                            <p class="summarycontent" style="<?php echo $displaySum ?>"><?php
                                $short = mb_substr($summary, 0, Yii::$app->params["maxCharactersSummary"], mb_detect_encoding($summary));
                                if ($short != $summary) {
                                    echo $short . "...";
                                } else {
                                    echo $summary;
                                }
                                ?></p>
                            <a class="blog-more-btn black" style="float:right;<?php echo $displayMore ?>" href="<?php echo $link; ?>"><?php echo Yii::t('app', "Read more"); ?> <i class="fa fa-long-arrow-right"></i></a>
                            <p>&nbsp;</p>
                        </div>
                    </article>
                </div>
                <div class="visible-xs visible-sm hidden-lg hidden-md" style="clear:both;"></div>
                <div class="dotted visible-xs visible-sm hidden-lg hidden-md"></div>
                <p class="visible-xs visible-sm hidden-lg hidden-md">
                    <br/>
                </p>
                <?php
                if (($i % 3) == 0) {
                    ?>
                    <div style="clear:both;"></div>
                    <p class="visible-lg visible-md hidden-sm hidden-xs">
                        <br/>
                    </p>
                    <?php
                }
            }
        }
        ?>
        <?php if ($typeDisplay == 2) {
            ?>
            <table class="table table-striped table-inverse table-bordered wow1 fadeInLeft1">
                <thead>
                    <tr>
                        <th style="width:10%;background-color: #CCC;">#</th>
                        <?php
                            if (in_array((int)$_GET['id'], Yii::$app->params['Id_change_readmore_to_download'])) {
                                ?>
                        <th style="width:10%;background-color: #CCC;"><?php echo Yii::t('app', "Photo"); ?></th>
                                <?php
                            }
                        ?>
                        <th style="width:60%;background-color: #CCC;"><?php echo Yii::t('app', "Title"); ?></th>
                        <th style="width:30%;background-color: #CCC;"><?php echo Yii::t('app', "Download"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($models) == 0) {
                        ?>
                        <tr>
                            <td colspan="3">
                                <div class="col-md-12" style="text-align: center;"><b><?php echo Yii::t('app', "There are no contents.") ?></b></div>
                            </td>
                        </tr>
                        <?php
                    } else {
                        $i = 0;
                        foreach ($models as $model) {
                            $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $model->photo;
                            $i++;
                            $pdfs = \backend\models\GallaryUploads::find()->where(['ref' => $model->ref])->andWhere(['or', ['like', 'real_filename', ".pdf"], [ 'like', 'real_filename', ".doc"]])->orderBy(['upload_id' => SORT_ASC])->all();
                            ?>
                            <tr>
                                <td style="width:10%" scope="row"><?php echo $i; ?></td>
                                <?php
                                    if (in_array((int)$_GET['id'], Yii::$app->params['Id_change_readmore_to_download'])) {
                                        ?>
                                <td>
                                    <img " src="<?php echo $photo; ?>" style="width:100%;margin-bottom: 15px;">
                                </td>
                                        <?php
                                    }
                                ?>

                                <td style="width:60%"><?php echo \dmstr\helpers\Html::a($model->title, ['site/detail', 'id' => $model->id]); ?></td>
                                <td style="width:30%">
                                    <?php
                                    foreach ($pdfs as $pdf) {
                                        $pdfurl = Yii::$app->urlManager->baseUrl . '/index.php?r=site/downloadfile&file=' . $model->ref . "/" . $pdf->real_filename;
                                        ?>
                                        <a style="color:#5588D9;" href="<?php echo $pdfurl; ?>"><?php echo $pdf->file_name; ?></a><br/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        <?php }
        ?>
        <div style = "clear:both;"></div>
        <?php if (!isset($notshowtitle)) { ?>
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
        }
    }
    ?>
    <?php //Pjax::end(); ?>
</div>
<div style="clear:both;"></div>
<p>&nbsp;<br/></p>