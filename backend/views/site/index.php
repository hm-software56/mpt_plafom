<?php

use yii\widgets\LinkPager;
use yii\data\Pagination;
use backend\models\Content;
use yii\helpers\Url;
use backend\models\ContentCategory;
use backend\models\TypeHome;
use backend\models\Home;

$this->title = Yii::t('app', 'ການ​ເຄື່ອ​ນໄ​ຫວ');
?>

<?php
    $news = backend\models\Content::find()->localized(Yii::$app->language)->where(['status' => 1])->andWhere(['content_category_id' => Yii::$app->params["idContentNews"]])->limit(Yii::$app->params["maxNewsIndex"])->orderBy(['start_date' => SORT_DESC, 'id' => SORT_DESC])->all();
?>
<?php
if (count($news) == 0) {
    ?>
    <div class="oneitem" style="text-align: center;"><b><?php echo Yii::t('app', "There are no news.") ?></b></div>
    <?php
} else {
    $i = 0;
    foreach ($news as $new) {
        $i++;
        $link = Yii::$app->urlManager->baseUrl . '/index.php?r=site/detail&id=' . $new->id;
        if (isset($new->photo) && !empty($new->photo)) {
            $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . $new->photo;
        } else {
            $photo = Yii::$app->urlManager->baseUrl . '/images/' . Yii::$app->params['downloadFilePath'] . "/" . Yii::$app->params['defaultNewsPhoto'];
        }
        $summary = $new->summary;
        if ($i == 1) {
            $classheight = "heightone";
            $class = "col-md-8 col-lg-8 col-xs-12 col-sm-12 specmarg";
        } else {
            $classheight = "heighttwo";
            $class = $class = "col-md-4 col-lg-4 col-xs-12 col-sm-12 specmarg";
        }

        $delay = "." . ($i * 2) . "s";
        $classfade = "fadeInLeft";
        if (($i % 2) == 0) {
            $classfade = "fadeInRight";
        }
        ?>
        <article class="aa-latest-blog-single td_photo_news  <?= $class ?> wow <?= $classfade ?>" style="float:left;margin-right:0px;" data-wow-delay="<?= $delay ?>">
            <figure class="aa-blog-img <?= $classheight ?>">
                <a href="<?php echo $link; ?>"><img alt="<?php echo $new->title ?>" src="<?php echo $photo; ?>" class="img-responsive"></a>
                <figcaption class="aa-blog-img-caption" style="text-align:left !important;">
                    <a href="<?php echo $link; ?>"><?php echo $new->title ?></a>
                </figcaption>
            </figure>
        </article>
            <?php
    }
    ?>
    <?php
}
?>
<?php
$typhome=TypeHome::find()->localized()->where(['status'=>1])->all();
foreach ($typhome as $typhome) {
    ?>
<div>
    <div class="aa-blog-content heightauto">
        <div style="margin-bottom:10px;min-height:40px;background-color:#5588D9 !important; font-size:18px; color:#ffffff;padding:5px; text-align:center;">
        <?=$typhome->name?>
        </div>
        <?php
            $homes=Home::find()->localized()->where(['type_home_id'=>$typhome->id])->all();
    foreach ($homes as $home) {
        ?>
                <div class="col-md-4">
                    <div class="border-all" style="margin-bottom:5px;">
                        <?php
                        if (!empty($home->like)) {
                            ?>
                        <a href="<?=Yii::$app->urlManager->baseUrl?>/<?=$home->like?>">
                        <?php
                        }
                        ?>
                            <img src="<?=Yii::$app->urlManager->baseUrl?>/images/download/<?=$home->photo?>" class="img-responsive img-center img-rounded" style="height:172px;"/>
                            <?=$home->name?>
                            <?php
                        if (!empty($home->like)) {
                            ?>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
        <?php
    } ?>
    </div>
</div>
<?php
}
?>
