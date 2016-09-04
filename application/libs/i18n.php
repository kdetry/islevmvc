<?php

class i18n {
	
	protected $path = "i18n_strings";
	protected $lang = "en";
	protected $dir;
	protected $_phrases = array();
	
	public function __construct($lang='en', $dir = 'language')
	{
		$this->setLang($lang);
		$this->setDir(APP.DIRECTORY_SEPARATOR.$dir.$this->path.DIRECTORY_SEPARATOR);
		$this->loadPhrases();
	}
	
	protected function setLang($lang)
	{
		$this->lang = $lang;
	}
	protected function setDir($dir)
	{
		$this->dir = $dir;
	}	
	
	protected function loadPhrases($type = 'txt', $seperator = '=')
	{
            //Burada Kaldım 05:41 24.07.2016
		$filename = $this->dir.'messages_'.$this->lang.'.'.$type;
		if(!file_exists($filename)) {
			return false;
		}
		$f = file($file);
		foreach($f as $line){
			list($key,$value) = explode($seperator,$line);
			$this->_phrases[$key] = $value;
		}
	}
        
	public function getPhrase($phrase)
	{
		$args = func_get_args();
		array_shift($args);
		if(!array_key_exists($phrase, $this->_phrases))
		{
			return null;
		}
		$text = $this->_phrases[$phrase];
		foreach($args as $key=>$arg)
		{
			$text = str_replace("{".$key."}", $arg, $text);
		}
		return $text;
	}
}
