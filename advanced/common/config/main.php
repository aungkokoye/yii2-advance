<?php

use yii\caching\FileCache;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'container' => [
        'definitions' => [
            'yii\widgets\ActiveForm' => [
                'fieldConfig' => [
                    'options' => ['class' => 'form-group mb-4'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block text-danger'],
                    'inputOptions' => ['class' => 'form-control'],
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                ],
                'requiredCssClass' => 'required',
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'formatter' => [
            'class'             => 'yii\i18n\Formatter',
            'dateFormat'        => 'php:Y-m-d',
            'datetimeFormat'    => 'php:Y-m-d H:i:s',
            'timeFormat'        => 'php:H:i:s',
        ],
    ],
];
