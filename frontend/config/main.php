<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/order/create',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
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
                // STANDARD REST API -moody
                'GET <controller>' => '<controller>/index',
                'GET <controller>/<id:\d+>' => '<controller>/view',
                'POST <controller>' => '<controller>/create',
                'PUT <controller>/<id:\d+>' => '<controller>/update',
                'DELETE <controller>/<id:\d+>' => '<controller>/delete',
                // STANDARD ROUTES WITH NESTED ROUTES
                '<controller>/<action>' => '<controller>/<action>',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<id:\d+>/<action>/<action_id:\d+>' => '<controller>/<action>',
                '<controller>/<action>/<id:\d+>/<aux_id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
