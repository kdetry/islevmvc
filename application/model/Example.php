<?php

class Example extends BaseModel
{
    //static $table variable for the CommonQueries Trait
    public static $table = 'Example';


    /* You can call this class as
     * $etc = new Example();
     * for function
     * $etc->exampleFunction();
     * Or you can call CommonQueries functions like
     * $etc->getById(1);
     */
    use CommonQueries;

    public function __construct()
    {
        parent::__construct();
    }

    public function exampleFunction(){
        $conn = parent::getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from(self::$table);
        $r = $qb->execute()->fetchAll();
        return $r;
    }
}