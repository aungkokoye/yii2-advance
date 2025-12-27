<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Portfolio BE',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'blog' => ['class' => 'backend\modules\blog\Modules'],
        'goal' => ['class' => 'backend\modules\goal\Modules']
    ],
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
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'goal'              => 'goal/goal/index',
            ],
        ],
    ],
    'params' => $params,
];
