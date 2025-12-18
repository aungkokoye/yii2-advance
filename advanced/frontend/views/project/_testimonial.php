<?php

use common\models\Testimonial;
use kartik\rating\StarRating;
use yii\helpers\Html;

/** @var Testimonial $model */

?>

<div class="project-view__testimonial">
    <div class="project-view__testimonial-info">
        <?php
        $imageUrl = $model->customerImage ? $model->customerImage->getImageUrl() :
            Yii::getAlias('@web/images/user.png');
        echo Html::img(
            $imageUrl,
            [
                'alt' => $model->customerName,
                'class' => 'project-view__testimonial-image'
            ]);

        ?>
        <?= Yii::$app->formatter->asHtml($model->customerName) ?>

        <?= StarRating::widget([
            'name' => 'rating' . $model->id,
            'value' => $model->rating,
            'pluginOptions' => ['displayOnly' => true, 'size' => 'xs', 'showClear' => false, 'showCaption' => false],
        ])
        ?>
    </div>

    <div class="project-view__testimonial-title">
        <strong><?= $model->title ?></strong>
    </div>

    <div class="project-view__testimonial-review">
        <p><?= Yii::$app->formatter->asHtml($model->review) ?></p>
    </div>
</div>
