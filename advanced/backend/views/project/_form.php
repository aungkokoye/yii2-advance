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

    <?=  $form->field($model, 'uploadedFile')->widget(FileInput::class, [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showUpload'            => false,
                'showRemove'            => true,
                'showClose'             => false, // Disable close (x) icon
                'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'maxFileSize'           => 2048, //2MB
                'initialPreview'        => $model->getImageUrls(), // preview images absolute URLs array
                'initialPreviewAsData'  => true, // preview images set as data
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
