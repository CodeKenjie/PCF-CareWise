<?php

if(!function_exists('cleanText')){
    function cleanText($text){
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        return trim($text);
    }
}

if(!function_exists('arrayFlattenUnique')){
    function arrayFlattenUnique($array){
        return array_values(array_unique($array));
    }
}

if(!function_exists('similarTextScore')){
    function similarTextScore($a, $b){
        similar_text($a, $b, $percent);
        return (int) $percent;
    }
}
