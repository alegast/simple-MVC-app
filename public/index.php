<?php
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

define('PUBLIC_PATH', pathinfo(__FILE__, PATHINFO_DIRNAME));
define('APP_BASE_PATH', PUBLIC_PATH . '/../');
define('VIEW_PATH', APP_BASE_PATH . 'src/View/');

$app = System\Application::getInstance();
$app->run();
