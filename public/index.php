<?php
define('ROOT', __DIR__.'/../');

if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

require APP . 'config/config.php';

// start the application
$app = new Application();