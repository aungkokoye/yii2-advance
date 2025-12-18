<?php

use yii\bootstrap5\Carousel;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Project $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="project-view__start-end-date">
        <?= Yii::t('app', 'From {start_date} to {end_date}', [
            'start_date' => Yii::$app->formatter->asDate($model->start_date),
            'end_date' => $model->end_date ? Yii::$app->formatter->asDate($model->end_date) : Yii::t('app', 'Present'),
        ]) ?>

    </div>


    <?= Carousel::widget([
            'items' => $model->getCarouselImageUrls(),
            'options' => ['class' => 'project-view__carousel'],
    ]); ?>

    <div class="project-view__tech-stack">
        <strong><?= Yii::t('app', 'Tech Stack:') ?></strong>
        <?= Yii::$app->formatter->asHtml($model->tech_stack) ?>
    </div>

    <div class="project-view__description">
        <strong><?= Yii::t('app', 'Description:') ?></strong>
        <?= Yii::$app->formatter->asHtml($model->description) ?>
    </div>

    <?php if($model->testimonials): ?>
        <hr>
        <h2><?= Yii::t('app', 'Testimonials') ?></h2>
        <br/>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'project-view__testimonial-item'],
        'itemView' => '_testimonial',
        'layout'    => "{items}\n{pager}",  // "{summary}{items}\n{pager}" default layout
        'pager' => [
            'class' => LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
        ],
    ])
    ?>
</div>
