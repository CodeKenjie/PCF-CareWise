<?php

namespace App\Services\Medical;

class EmergencyDetector {
    protected $rules;

    public function __construct(){
        $this->rules = require DATA_PATH . '/emergency_rules.php';
    }

    public function detect($symptoms){
        $inputSymptoms = array_flip($symptoms);
        foreach($this->rules as $rule){
            $matched = true;
            foreach($rule['symptoms'] as $symptom){
                if(!isset($inputSymptoms[$symptom])){
                    $matched = false;
                    break;
                }
            }

            if($matched){
                return [
                    'emergency' => true,
                    'name' => $rule['name'],
                    'urgency' => $rule['urgency'],
                    'message' => $rule['message']
                ];
            }
        }

        return null;
    }
}