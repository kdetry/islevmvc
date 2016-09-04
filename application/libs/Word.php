<?php

class Word
{
    static public function excerpt($str, $startPos = 0, $maxLength = 100)
    {
        $str = strip_tags($str);
        if (strlen($str) > $maxLength) {
            $excerpt = mb_substr($str, $startPos, $maxLength - 3);
            $lastSpace = mb_strrpos($excerpt, ' ');
            $excerpt = mb_substr($excerpt, 0, $lastSpace);
            $excerpt .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }
}