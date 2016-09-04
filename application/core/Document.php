<?php

class Document
{

    private static $title;
    private static $description;
    private static $keywords;
    private static $styles = array();
    private static $scripts = array();

    public function setTitle($title)
    {
        self::$title = $title;
    }

    public function getTitle()
    {
        return self::$title;
    }

    public function setDescription($description)
    {
        self::$description = $description;
    }

    public function getDescription()
    {
        return self::$description;
    }

    public function setKeywords($keywords)
    {
        self::$keywords = $keywords;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        self::$styles[$href] = array(
            'href' => $href,
            'rel' => $rel,
            'media' => $media
        );
    }

    public function getStyles()
    {
        return $this->styles;
    }

    public function addScript($script)
    {
        self::$scripts[md5($script)] = $script;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

}
