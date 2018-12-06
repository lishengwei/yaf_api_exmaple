<?php

define('APPLICATION_PATH', dirname(__FILE__));

//加载配置环境
$env            = getenv('ARM_API_ENV');
//引入不同环境的配置
$application    = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini", $env);

$application->bootstrap()->run();

