<?php
return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'mail'  => [
//            'class'            => 'yii\swiftmailer\Mailer',
//            //'transportType'    => 'smtp',
//            'SMTPOptions' => [
//                'isSMTP' => true,
//                'host'       => 'smtp.gmail.com',
//                'username'   => 'meatloafpaylease@gmail.com',
//                'password'   => 'Super.123',
//                'port'       => '465',
//                'SMTPAutoTLS' => true,
//                'SMTPAuth'   => true,
//                //'viewPath'   => '@common/mail',
//            ],
//        ],
    ],
];
