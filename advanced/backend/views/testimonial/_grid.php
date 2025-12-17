<?php

/** @var yii\web\View $this */
/** @var backend\models\TestimonialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $projects */
/** @var bool $projectShow */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Testimonial;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\rating\StarRating;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            'attribute'     => 'project_id',
            'format'        => 'html',
            'value'         => function ($model) {
                /** @var  Testimonial $model */
                return Html::a(
                    Html::encode($model->project->name),
                    ['project/view', 'id' => $model->project_id]
                );
            },
            'visible'       => $projectShow,
            'filter'        => Html::activeDropDownList(
                $searchModel,
                'project_id',
                $projects,
                [
                    'class' => 'form-control custom-select',
                    'prompt' => Yii::t('app', 'All Projects'),
                ]
            ),
        ],
        [
            'attribute'     => 'customer_image_id',
            'format'        => 'html',
            'enableSorting' => false,
            'value'         => function ($model) {
                /** @var  Testimonial $model */
                return Html::img($model->customerImage->getImageUrl(),
                    [
                        'style' => 'margin-right:10px;',
                        'height'=> 75,
                    ]
                );
            }
        ],
        'title',
        'customerName',
        //'review:ntext',
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
            'filter'        => Html::activeDropDownList(
                $searchModel,
                'rating',
                array_combine(range(1, 5), ['★', '★★', '★★★', '★★★★', '★★★★★']),
                [
                    'class' => 'form-control custom-select',
                    'prompt' => Yii::t('app', 'All Rating'),
                ]
            ),
        ],
        [
            'class' => ActionColumn::class,
            //'controller' => 'testimonial',
            'urlCreator' => function ($action, Testimonial $model, $key, $index, $column) {
                return Url::toRoute(['testimonial/' . $action, 'id' => $model->id]);
            }
        ],
    ],
]);