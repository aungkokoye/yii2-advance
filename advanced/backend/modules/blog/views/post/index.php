<?php

use common\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\modules\blog\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
//            [
//                'attribute' => 'body',
//                'format' => 'html',
//                'contentOptions' => [
//                    'style' => 'max-width:50%; white-space:normal; word-wrap:break-word;',
//                ],
//                'headerOptions' => [
//                    'style' => 'width:50%;',
//                ],
//            ],
            [
                'attribute'     => 'is_published:',
                'value'         => function ($model) {
                                        /** @var  Post $model */
                                        return $model->is_published ? 'Yes' : 'No';
                                    },
                'filter' => Html::activeDropDownList(
                                $searchModel,
                        'is_published',
                                [
                                    1 => Yii::t('app', 'Yes'),
                                    0 => Yii::t('app', 'No'),
                                ],

                                [
                                    'class' => 'form-control custom-select',
                                    'prompt' => Yii::t('app', 'All'),
                                ]
                            ),
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
