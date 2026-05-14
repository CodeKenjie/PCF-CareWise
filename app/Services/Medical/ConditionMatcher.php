<?php

namespace App\Services\Medical;

class ConditionMatcher {
    protected $conditions;

    public function __construct(){
        $this->conditions = require DATA_PATH . '/conditions.php';
    }

    public function match(array $symptoms) {
        $results = [];

        $inputSymptoms = array_flip($symptoms);

        foreach($this->conditions as $condition => $data){
            $score = 0;
            $matchedSymptoms = [];
            $maxScore = array_sum($data['symptoms']);

            foreach($data['symptoms'] as $symptom => $weight){
                if(isset($inputSymptoms[$symptom])){
                    $score += $weight;
                    $matchedSymptoms[]= $symptom;
                }
            }

            if($score < 5){
                continue;
            }

            $confidence = round(($score / $maxScore) * 100);

            if($confidence < 25){
                continue;
            }

            $confidenceLevel = match (true){
                $confidence >= 80 => 'High',
                $confidence >= 50 => 'MODERATE',
                default => 'LOW'
            };

            $results[] = [
                'condition' => $condition,
                'confidence' => $confidence,
                'confidenceLevel' => $confidenceLevel,
                'urgency' => $data['urgency'],
                'description' => $data['description'],
                'matched_symptoms' => $matchedSymptoms,
                'medications' => $data['medications'],
            ];
        }

        usort($results, function($a, $b){
            return $b['confidence'] <=> $a['confidence'];
        });

        return $results;
    }
}