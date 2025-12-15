<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'formatter' => [
            'class'             => 'yii\i18n\Formatter',
            'dateFormat'        => 'php:Y-m-d',
            'datetimeFormat'    => 'php:Y-m-d H:i:s',
            'timeFormat'        => 'php:H:i:s',
        ],
    ],
];
