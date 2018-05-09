<?php
// 本文件在app/web/index.php 处引入。

// flexcrm的核心模块
$modules = [];
foreach (glob(__DIR__ . '/modules/*.php') as $filename) {
    $modules = array_merge($modules, require($filename));
}
$params = require __DIR__ .'/params.php';

return [
    'modules' => $modules,
    'params' => $params,
    'components' => [
        'user' => [
            'identityClass' => '',
            'enableAutoLogin' => false
        ],
        'i18n' => [
            'translations' => [
                'admin' => [
                    'class' => '',
                    'basePaths' => [

                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => ''
        ],
        'urlManager' => []
    ]
];