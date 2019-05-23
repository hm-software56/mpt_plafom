<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Results of Search');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="divcontent">
    <div style="margin-bottom: 30px;">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"><?= Yii::t('app', 'Search') ?></legend>
            <form method="post" role="search" action="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/search" class="wow fadeInRight">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                <div style="width: 80% !important; float: left;">
                    <input type="text" name="search" id="" placeholder="<?php echo Yii::t("app", "Search") ?>" class="form-control input-search" value="<?php echo Yii::$app->session['search']; ?>"/><br/>

                    <label style="margin-top: 10px"><?= Yii::t("app", "Content Category") ?></label>
                    <?=
                    Html::dropDownList('content_category_id', Yii::$app->session['content_category_id'], ArrayHelper::map(\backend\models\ContentCategory::find()->localized()->where(['status' => 1])->all(), 'id', 'title'), [
                        'prompt' => Yii::t('app', '---Please select---'),
                        'class' => 'form-control',
                    ])
                    ?></div>
                <div style="width: 20% !important; float: left;margin-top:4px;"><button type="submit" class="btn btn-primary" style="margin-left:5%;"><span class="fa fa-search"></span></button></div>
                <div style="clear:both;"></div>
                <p>&nbsp;<br/></p>
            </form>

            </legend>
        </fieldset>
    </div>
    <div style="clear:both;"></div><br/>
    <table class="table table-striped table-inverse table-bordered wow fadeInLeft">
        <thead>
            <tr>
                <th style="width:10%;background-color: #CCC;">#</th>
                <th style="width:60%;background-color: #CCC;"><?php echo Yii::t('app', "Title"); ?></th>
                <th style="width:30%;background-color: #CCC;"><?php echo Yii::t('app', "Content Category"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($results) == 0) {
                ?>
                <tr>
                    <td colspan="3">
                        <div class="col-md-12" style="text-align: center;"><b><?php echo Yii::t('app', "No results matched your search request.") ?></b></div>
                    </td>
                </tr>
                <?php
            } else {
                $i = 0;
                foreach ($results as $result) {
                    $i++;
                    ?>
                    <tr>
                        <td style="width:10%" scope="row"><?php echo $i; ?></td>
                        <td style="width:60%" ><?php echo \dmstr\helpers\Html::a($result->title, ['site/detail', 'id' => $result->id]); ?></td>
                        <td style="width:30%"><?php echo $result->contentCategory->title; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <div style="text-align: center;margin-bottom: 20px;">
        <?php
        if (count($results) > 0) {
            echo yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]);
        }
        ?>
    </div>
    <div style="clear:both;"></div>
</div>


