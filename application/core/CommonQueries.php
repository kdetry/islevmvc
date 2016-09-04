<?php

/**
 * Created by PhpStorm.
 * User: Mustafa
 * Date: 25.08.2016
 * Time: 04:50
 */
trait CommonQueries
{

    /**
     * @param array $to_category_ids
     * @return array
     */
    public function getMultiById($to_ids = array(), $additional = array())
    {
        $conn = BaseModel::getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from(self::$table);
        for ($i = 0; $i < count($to_ids); $i++) {
            if ($i == 0) {
                $qb->where('id = ?');
            } else {
                $qb->orWhere('id = ?');
            }
        }
        if (count($additional) > 0) {
            foreach ($additional as $key => $value) {
                $qb->andWhere($key . ' = ' . $value);
            }
        }
        for ($i = 0; $i < count($to_ids); $i++) {
            $qb->setParameter($i, $to_ids[$i]);
        }
        $result = $qb->execute()->fetchAll();
        return $result;
    }


    /**
     * @param int $id
     * @param array $additional
     * @return mixed
     */
    public function getById($id = 0, $additional = array())
    {
        $conn = BaseModel::getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from(self::$table)
            ->where('id = ?');
        if (count($additional) > 0) {
            foreach ($additional as $key => $value) {
                $qb->andWhere($key . ' = ' . $value);
            }
        }
        $qb->setParameter(0, $id);
        $result = $qb->execute()->fetch();
        return $result;
    }


    /**
     * @param int $content_id
     * @param string $to_table
     * @return array
     */
    public function to($content_id = 1, $to_table = '')
    {
        $table = self::$table . '_to_' . $to_table;
        $conn = BaseModel::getConnection();
        $sm = $conn->getSchemaManager();
        if ($sm->tablesExist($table) == true) {
            $qb = $conn->createQueryBuilder();
            $qb->select('*')
                ->from($table)
                ->where(self::$table . '_id = ?');
            $qb->setParameter(0, $content_id);
            $result = $qb->execute()->fetchAll();
        } else {
            $result = array();
        };
        return $result;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug, $additional = array())
    {
        $conn = BaseModel::getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from(self::$table)
            ->where('slug = ?');
        if (count($additional) > 0) {
            foreach ($additional as $key => $value) {
                $qb->andWhere($key . ' = ' . $value);
            }
        }
        $qb->setParameter(0, $slug);
        $result = $qb->execute()->fetch();
        return $result;
    }


    /**
     * @return array
     */
    public function getAllTable()
    {
        $conn = BaseModel::getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select('*')
            ->from(self::$table);
        $result = $qb->execute()->fetchAll();
        return $result;
    }

}