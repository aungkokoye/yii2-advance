<?php

use kartik\editors\Summernote;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Project $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-4'],
            'errorOptions' => ['class' => 'invalid-feedback d-block text-danger'],
            'inputOptions' => ['class' => 'form-control'],
            'labelOptions' => ['class' => 'form-label'],
        ],
        'requiredCssClass' => 'required',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tech_stack')->widget(Summernote::class, [
        'useKrajeePresets' => true,
    ]) ?>

    <?= $form->field($model, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
    ]) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?=  $form->field($model, 'uploadedFiles[]')->widget(FileInput::class, [
            'options' => [
                    'accept'    => 'image/*',
                    'multiple'  =>  true
            ],
            'pluginOptions' => [
                'showUpload'            => false,
                'showRemove'            => true,
                'showClose'             => false, // Disable close (x) icon
                'allowedFileExtensions' => Yii::$app->params['allowedUploadImageExtensions'],
                'maxFileCount'          => Yii::$app->params['maxUploadFiles'],
                'maxFileSize'           => Yii::$app->params['maxUploadFileSize'] / 1024, // Convert bytes to KB
                'initialPreview'        => $model->getImageUrls(), // preview images absolute URLs array
                'initialPreviewAsData'  => true, // preview images set as data [ 'key' => 'model-id' ]
                'deleteUrl'             => Url::to(['project/delete-project-image']),
                'initialPreviewConfig'  => $model->getPreviewImageConfig(),
                'fileActionSettings'    => [
                    'showZoom'    => false, // Hide zoom/enlarge icon
                    'showRemove'  => true,  // Show delete icon
                    'showUpload'  => false, // Hide upload icon
                    'showDrag'    => false, // Hide drag icon
                ],
            ]
        ])
    ?>

    <div class="form-group mt-4">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
