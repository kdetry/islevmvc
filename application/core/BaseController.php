<?php

abstract class BaseController
{

    protected static $config;

    function __construct()
    {
        if (empty(self::$config)) {
            self::$config = $this->setConfig();
        }
    }

    private function setConfig()
    {
        $conn = BaseModel::getConnection();
        $queryBuilder = $conn->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('config')
            ->orderBy('id', 'DESC')
            ->setMaxResults(1);
        $result = $queryBuilder->execute()->fetch();
        return $result;
    }

    protected function getConfig($param)
    {
        if (isset(self::$config[$param])) {
            $val = self::$config[$param];
        } else {
            $val = false;
        }
        return $val;
    }

}
