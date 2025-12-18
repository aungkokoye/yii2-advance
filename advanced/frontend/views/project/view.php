<?php

use yii\bootstrap5\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Project $model */

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
        <?= Yii::$app->formatter->asHtml($model->description) ?>
    </div>




</div>
