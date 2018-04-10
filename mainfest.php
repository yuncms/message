<?php
return [
    'id'=> 'message',
    'migrationPath' => '@vendor/yuncms/message/migrations',
    'translations' => [
        'yuncms/message' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/yuncms/message/messages',
        ],
    ],
    'frontend' => [
        'class'=>'yuncms\message\frontend\Module'
    ],
];