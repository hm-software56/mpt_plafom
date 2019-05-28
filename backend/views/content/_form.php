<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
//use kartik\widgets\FileInput;
use kartik\file\FileInput;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Content */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($contentcategory->has_photo) { ?>
        <?= $form->field($model, 'remove_photo')->hiddenInput(['value' => 0])->label(FALSE) ?>
        <?php if (!$model->isNewRecord && isset($model->photo) && !empty($model->photo)) { ?>
            <div id="rm_df" style="width:100%;float:left;"><button title="<?= Yii::t('app', "Remove old photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#content-remove_photo').val('1');
        			$('#rm_df').css({'display': 'none'});
        			return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Remove old photo"); ?></button></div>
                                                               <?php } ?>
        <div style="float:left;"><?= $form->field($model, 'photo')->fileInput(['maxlength' => true]) ?> </div>
        <div style="float:left;"><br/><button title="<?= Yii::t('app', "Cancel photo"); ?>" class="btn btn-sm btn-danger" onclick="$('#content-photo').val('');
    			return false;"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('app', "Cancel photo"); ?></button>
        </div>
        <div style="clear:both;"></div>
    <?php } ?>

    <?php
    foreach (Yii::$app->params['languages'] as $language => $value) {
        if ($language != Yii::$app->params['defaultLang']) {

            ?>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><?= $value ?></legend>
                <div class="control-group">
                    <?= $form->field($model, 'title_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Title')) ?>
					
                    <?php if ($contentcategory->has_summary) { ?>
					<?php
					if(Yii::$app->session['type']==11)
					{
						echo $form->field($model, 'summary_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Link'));
					}else{
						echo $form->field($model, 'summary_' . $language)->textarea(['rows' => 6])->label(Yii::t("app", 'Summary'));
					}
					?>
                    <?php } ?>
                    <?php
                    if (Yii::$app->session['type']==9) {
                        echo $form->field($model, 'keywords_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'URL'));
                    }
                    ?>
                    <?php if ($contentcategory->has_details) { ?>
                        <?php
                        echo $form->field($model, 'details_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::t("app", 'Details'));

                        ?>
                    <?php } ?>
                    <?php if ($contentcategory->has_keywords) { ?>
                        <?= $form->field($model, 'keywords_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Keywords')) ?>
                    <?php } ?>
                    <?php if ($contentcategory->has_meta_keywords) { ?>
                        <?= $form->field($model, 'meta_keywords_' . $language)->textInput(['maxlength' => true])->label(Yii::t("app", 'Meta Keywords')) ?>
                    <?php } ?>
                    <?php if ($contentcategory->has_add1) { ?>
                        <?php
                        echo $form->field($model, 'add_1_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentAdd1']);
                    }

                    ?>
                    <?php if ($contentcategory->has_add2) { ?>
                        <?php
                        echo $form->field($model, 'add_2_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentAdd2']);
                    }

                    ?>
                    <?php if ($contentcategory->has_add3) { ?>
                        <?php
                        echo $form->field($model, 'add_3_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentAdd3']);
                    }

                    ?>
                    <?php if ($contentcategory->has_add4) { ?>
                        <?php
                        echo $form->field($model, 'add_4_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentAdd4']);
                    }

                    ?>
                    <?php if ($contentcategory->has_add5) { ?>
                        <?php
                        echo $form->field($model, 'add_5_' . $language)->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full',
                                'inline' => false,
                            ]),
                        ])->label(Yii::$app->params['labelContentAdd5']);
                    }

                    ?>
                </div>
            </fieldset>
            <?php
        } else {

            ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?php if ($contentcategory->has_summary) { ?>
				<?php
				if(Yii::$app->session['type']==11)
					{
						echo $form->field($model, 'summary')->textInput(['maxlength' => true])->label(Yii::t("app", 'Link'));
					}else{
						echo $form->field($model, 'summary')->textarea(['rows' => 6]);
					}
				?>
            <?php } ?>
            <?php
            if (Yii::$app->session['type']==9) {
                echo $form->field($model, 'keywords')->textInput(['maxlength' => true])->label(Yii::t("app", 'URL'));
            }
            ?>
            <?php if ($contentcategory->has_details) { ?>
                <?php
                echo $form->field($model, 'details')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ]);

                ?>
            <?php } ?>
            <?php if ($contentcategory->has_keywords) { ?>
                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
            <?php } ?>
            <?php if ($contentcategory->has_meta_keywords) { ?>
                <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
            <?php } ?>
            <?php if ($contentcategory->has_add1) { ?>
                <?php
                echo $form->field($model, 'add_1')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentAdd1']);
            }

            ?>
            <?php if ($contentcategory->has_add2) { ?>
                <?php
                echo $form->field($model, 'add_2')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentAdd2']);
            }

            ?>
            <?php if ($contentcategory->has_add3) { ?>
                <?php
                echo $form->field($model, 'add_3')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentAdd3']);
            }

            ?>
            <?php if ($contentcategory->has_add4) { ?>
                <?php
                echo $form->field($model, 'add_4')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentAdd4']);
            }

            ?>
            <?php if ($contentcategory->has_add5) { ?>
                <?php
                echo $form->field($model, 'add_5')->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                        'preset' => 'full',
                        'inline' => false,
                    ]),
                ])->label(Yii::$app->params['labelContentAdd5']);
            }

            ?>
            <?php
        }
    }

    ?>

    <?php
    if ($contentcategory->has_start_date) {
        if (!$contentcategory->has_end_date) {
            $label = Yii::t("app", "Date");
        } else {
            $label = Yii::t("app", "Start Date");
        }

        ?>
        <?= $form->field($model, 'start_date')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']])->label($label) ?>

    <?php } ?>
    <?php if ($contentcategory->has_end_date) { ?>
        <?= $form->field($model, 'end_date')->textInput()->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
    <?php } ?>


    <?= $form->field($model, 'status')->checkbox() ?>
    <?= $form->field($model, 'ref')->hiddenInput(['maxlength' => 100])->label(false); ?>

    <?php if ($contentcategory->has_multi_attachment) { ?>
        <div class="form-group field-upload_files">
            <label class="control-label" for="upload_files[]"> <?php echo Yii::t("app", 'Upload Attachments'); ?> </label>
            <div>
                <?=
                FileInput::widget([
                    'name' => 'upload_ajax[]',
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'overwriteInitial' => false,
                        'initialPreviewShowDelete' => true,
                        'encodeUrl'=>false,
                        'initialPreview' => $initialPreview,
                        'initialPreviewConfig' => $initialPreviewConfig,
                        'uploadUrl' => Url::toRoute(['/content/upload-ajax']),
                        'uploadExtraData' => [
                            'ref' => $model->ref,
                        ],
                        'maxFileCount' => 100,
                        'previewFileType' => 'any'
                    ]
                ]);

                ?>
                <span style="color:red"><?= Yii::t('app', 'Please click the button upload above') ?></span>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
