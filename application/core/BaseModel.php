<?php

class BaseModel
{

    public static function getConnection()
    {
        $config = new \Doctrine\DBAL\Configuration();

        $connParams = array(
            'dbname' => DB_NAME,
            'user' => DB_USER,
            'password' => DB_PASS,
            'host' => DB_HOST,
            'driver' => 'pdo_' . DB_TYPE,
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        );
        return \Doctrine\DBAL\DriverManager::getConnection($connParams, $config);
    }

}
