<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'HAZ PATOLOGIA',
    // set source language to be English
    'sourceLanguage' => 'en-US',
    'language' => 'es-ES',
    'timeZone'  => 'America/Buenos_Aires',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dfsdddfgf3asdfsdfssdfsd4353443534se',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ]
        ,
     //    'formatter' => [
     //     'class' => 'yii\i18n\Formatter',
     //     'locale' => 'es-ES',
     //     'dateFormat' => 'dd/mm/yyyy',
     //     'timeFormat' => 'short',
     //     'defaultTimeZone' => 'Europe'
     // ],


        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'es-ES',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'catchAll' => [
              'class' => 'yii\web\ErrorAction',
          'site/error'
      ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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

        'db' => $db,
        'urlManager' => [
             'enablePrettyUrl' => true,
             'showScriptName' => false,
             'rules' => [
                 // '' => 'web/site/index',
                 // '<action>'=>'site/<action>',
               ['class'=>'yii\rest\UrlRule', 'controller' =>'vistaestudio'],
               ['class'=>'yii\rest\UrlRule', 'controller' =>'biopsiarest',
               // 'pluralize'=>false,
               'extraPatterns'=>['OPTIONS informe'=>'informe','GET informe'=>'informe' ]],
               ['class'=>'yii\rest\UrlRule',
                   'controller' => 'userrest',
                    'pluralize'=>false,
                    'extraPatterns'=>['POST authenticate'=>'authenticate',
                            'OPTIONS authenticate'=>'authenticate',
                      ],
               ]

               ],
         ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
      ],
      //restringir el acceso y volver al login si no esta registrado
      'as beforeRequest' => [
          'class' => 'yii\filters\AccessControl',
          'rules' => [
              [
                  'allow' => true,
                  'actions' => ['login'],
              ],
              [
                  'allow' => true,
                  'roles' => ['@'],
              ],
              [
                  'allow' => false,
                  'actions' => ['login'],
                  'roles' => ['@'],
              ],
          ],
          'denyCallback' => function () {
              return Yii::$app->response->redirect(['site/login']);
          },
      ],

      'modules' => [
     //    'pdfjs' => [
     //     'class' => '\yii2assets\pdfjs\Module',
     // ],
        'datecontrol' =>  [
           'class' => '\kartik\datecontrol\Module'
       ],
          'gridview' => ['class' => 'kartik\grid\Module'],
          'i18n' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@kvgrid/messages/es',
    'forceTranslation' => false]
      ] ,
    'params' => $params,

];


if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];


}

return $config;
