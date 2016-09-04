<?php
define('ROOT', '/home2/bebepuf/public_html/mvc11/');

if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

require APP . 'config/config.php';

//Şimdilik Kalacak, ilerde ilgilenilecek
//require APP . 'libs/helper.php';

// start the application
$app = new Application();