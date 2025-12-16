<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Testimonial $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $projectsDropdownData */
?>

<div class="testimonial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->dropDownList(
            $projectsDropdownData,
            ['prompt' => '--- ' . Yii::t('app', 'Select a Project') . ' ---']
    )?>

    <?=  $form->field($model, 'uploadedFile')->widget(FileInput::class, [
        'options' => [
            'accept'    => 'image/*',
        ],
        'pluginOptions' => [
            'showUpload'            => false,
            'showRemove'            => true,
            'showClose'             => false, // Disable close (x) icon
            'allowedFileExtensions' => Yii::$app->params['allowedUploadImageExtensions'],
            'maxFileSize'           => Yii::$app->params['maxUploadFileSize'] / 1024, // Convert bytes to KB
            'initialPreview'        => $model->getImageUrls(), // preview images absolute URLs array
            'initialPreviewAsData'  => true, // preview images set as data [ 'key' => 'model-id' ]
            'deleteUrl'             => Url::to(['testimonial/delete-image']),
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customerName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'review')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
