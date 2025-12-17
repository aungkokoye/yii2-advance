<?php

use common\models\Testimonial;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Testimonial $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testimonials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="testimonial-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Project'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->project->name, ['project/view', 'id' => $model->project->id]);

                },
            ],
            [
                'label' => Yii::t('app', 'Image'),
                'format' => 'html',
                'value' => function ($model) {
                    /** @var  Testimonial $model */
                    if (!$model->customerImage) {
                        return null;
                    }

                    return Html::img($model->customerImage->getImageUrl(),
                        [
                            'style' => 'margin-right:10px;',
                            'height'=> 200,
                        ]);
                }
            ],
            'title',
            'customerName',
            'review:ntext',
            [
                'attribute'     => 'rating',
                'format'        => 'raw',
                'value'         => function ($model) {
                    return StarRating::widget([
                        'name' => 'rating' . $model->id,
                        'value' => $model->rating,
                        'pluginOptions' => ['displayOnly' => true, 'size' => 'xs', 'showClear' => false, 'showCaption' => false],
                    ]);
                },
            ],
        ],
    ]) ?>

</div>
