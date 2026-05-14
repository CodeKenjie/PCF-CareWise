<?php

namespace App\Services\Medical;

class SymptomNormalizer {
    protected $aliases; 
    protected $allSymptoms = null;

    public function __construct(){
        $this->aliases = require DATA_PATH . '/aliases.php';
    }

    protected function getAllSymptoms(){
        $conditions = require DATA_PATH . '/conditions.php';
        $emergencyRules = require DATA_PATH . '/emergency_rules.php';
        $symptoms = [];
        foreach($conditions as $condition){
            foreach($condition['symptoms'] as $symptom => $weight){
                $symptoms[] = $symptom;
            }
        }

        foreach($emergencyRules as $rule){
            foreach($rule['symptoms'] as $symptom){
                $symptoms[] = $symptom;
            }
        }
        return $this->allSymptoms = array_unique($symptoms);
    }

    public function normalize($text){
        $text = strtolower($text);
        $text = cleanText($text);

        foreach($this->aliases as $alias => $normalized){
            $pattern = '/\b' . preg_quote($alias, '/') . '\b/';
            $text = preg_replace($pattern . 'i', $normalized, $text);
        }

        $detected = [];
        $allSymptoms = $this->getAllSymptoms();
        foreach($allSymptoms as $symptom){
            if(preg_match('/\b' . preg_quote($symptom, '/') . '\b/', $text)){
                $detected[] = $symptom;
            }
        }

        return array_values(array_unique($detected));
    }
}