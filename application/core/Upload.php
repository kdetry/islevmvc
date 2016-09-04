<?php

class Upload
{

    public $valid_formats;
    public $inputName;

    public function __construct($valid_formats)
    {
        $this->valid_formats = $valid_formats;
    }

    private function slug($string)
    {
        $turkce = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
        $duzgun = array("s", "s", "i", "u", "u", "o", "o", "c", "c", "s", "s", "i", "g", "g", "i", "o", "o", "c", "c", "u", "u");
        $string = str_replace($turkce, $duzgun, $string);
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }

    private function uploadAction($name, $f = false)
    {
        $tmpname = explode('.', $name);
        $uzanti = end($tmpname);

        $son = count($tmpname) - 1;
        unset($tmpname[$son]);
        $tmpname = implode('.', $tmpname);
        $tmpname = $this->slug($tmpname);
        $name = $tmpname . '.' . $uzanti;
        if ($f !== false) {
            if ($_FILES[$this->inputName]['error'][$f] == 4) {
                return false;
            }
            if ($_FILES[$this->inputName]['error'][$f] == 0) {
                if (!in_array(pathinfo($name, PATHINFO_EXTENSION), $this->valid_formats)) {
                    $message[] = "$name is not a valid format";
                    return false;
                } else { // No error found! Move uploaded files 
                    $savedName = $this->renameRecursiveAndMove($name, $this->inputName, $f);
                }
            }
        } else {
            if ($_FILES[$this->inputName]['error']) {
                return false;
            }
            if ($_FILES[$this->inputName]['error'] == 0) {
                if (!in_array(pathinfo($name, PATHINFO_EXTENSION), $this->valid_formats)) {
                    $message[] = "$name is not a valid format";
                    return false;
                } else { // No error found! Move uploaded files 
                    $savedName = $this->renameRecursiveAndMove($name, $this->inputName);
                }
            }
        }

        return $savedName;
    }

    public function uploadFile($inputName)
    {
        if (!empty($inputName)) {
            $this->inputName = $inputName;
        }
        $savedFiles = array();

        if (is_array($_FILES[$this->inputName]['name'])) {
            foreach ($_FILES[$this->inputName]['name'] as $f => $name) {
                $savedName = $this->uploadAction($name, $f);
                if ($savedName !== false) {
                    $savedFiles[] = $savedName;
                }
            }
        } elseif (is_string($_FILES[$this->inputName]['name'])) {
            $savedFiles = $this->uploadAction($_FILES[$this->inputName]['name']);
        } else {
            $savedFiles = false;
        }
        return $savedFiles;
    }

    public function renameRecursiveAndMove($filename, $inputName, $f = false)
    {
        $length = 5;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $newfilename = $randomString . '_' . $filename;
        if (!file_exists(IMG_FOLDER . '/' . $newfilename)) {
            if ($f !== false) {
                $move = move_uploaded_file($_FILES[$inputName]["tmp_name"][$f], IMG_FOLDER . '/' . $newfilename);
            } else {
                $move = move_uploaded_file($_FILES[$inputName]["tmp_name"], IMG_FOLDER . '/' . $newfilename);
            }

            if ($move) {
                $savedName = $newfilename;
            }
        } else {
            $savedName = $this->renameRecursive($filename, $inputName);
        }
        return $savedName;
    }

}
