<?php

class Application
{

    public static $router;

    public function __construct()
    {

        $router = new AltoRouter();
        $router->setBasePath(BASE_PATH);
        require_once(APP.'config/routes.php');
        self::$router = $router;
        $match = $router->match();
        if ($match === false) {
            // here you can handle 404
        } else {
            $match['info'] = $this->splitMatch($match['target']);
            $controllerClass = new $match['info']['class'];
            call_user_func_array(array($controllerClass, $match['info']['function']), $match['params']);

            //$controller = new $match['info']['class'];
            //$controller->$match['info']['function']($match['params']);
            //$match['target']($match['params']);
        }
    }

    private function splitMatch($target)
    {
        if (strpos($target, '#')) {
            $tmpArray = explode('#', $target);
            $newTarget['class'] = $tmpArray[0];
            $newTarget['function'] = $tmpArray[1];
        } else {
            $newTarget['class'] = $target;
            $newTarget['function'] = 'index';
        }
        return $newTarget;
    }

}
