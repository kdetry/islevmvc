<?php

class Slug extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $string
     * @return string
     */
    private function slug($string)
    {
        $turkce = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
        $duzgun = array("s", "s", "i", "u", "u", "o", "o", "c", "c", "s", "s", "i", "g", "g", "i", "o", "o", "c", "c", "u", "u");
        $string = str_replace($turkce, $duzgun, $string);
        $deger = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
        return $deger;
    }

    /**
     * @param $string
     * @param array $searchDb
     * @return string
     */
    public function recursiveCheckSlug($string, $searchDb)
    {
        if (isset($searchDb['table']) && isset($searchDb['column'])) {
            $string = $this->slug($string);
            $queryBuilder = $this->db->createQueryBuilder();
            $queryBuilder->select('id')
                ->from($searchDb['table'])
                ->where($searchDb['column'] . ' = ?')
                ->setParameter(0, $string);
            $result = $queryBuilder->execute()->fetchAll();

            if (count($result) > 0) {
                $length = 3;
                $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
                $newstring = $string . '-' . $randomString;
                $string = $this->recursiveCheckSlug($newstring, $searchDb);
            }
            return $string;
        }
    }
}
