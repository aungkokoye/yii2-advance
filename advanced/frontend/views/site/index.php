<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = Yii::$app->name . "- Profile";
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <?= Html::img('@web/images/site-profile.jpg',[ 'alt' => 'My profile picture', 'class' => 'site-profile__image'])?>
            <h2 class="site-title__h2"><?= Yii::t('app', "My name is Aung") ?></h2>
            <p><?= Yii::t('app', 'Passionate to create Yii2 websites or web applications') ?></p>
            <p><?= Html::a(Yii::t('app','My Works'), ['project/'], ['class' => 'btn btn-primary'])?></p>
        </div>
    </div>

    <div class="body-content">

    </div>
</div>
