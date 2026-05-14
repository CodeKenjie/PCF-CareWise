<?php

namespace App\Services\Medical;

class MedicalAnalyzer {
    protected $normalizer;
    protected $emergencyDetector;
    protected $conditionMatcher;

    public function __construct(){
        $this->normalizer = new SymptomNormalizer();
        $this->emergencyDetector = new EmergencyDetector();
        $this->conditionMatcher = new ConditionMatcher();
    }

    public function analyze($input){
        $symptoms = $this->normalizer->normalize($input);
        $emergency = $this->emergencyDetector->detect($symptoms);
        if($emergency){
            return [ 'success' => true, 'emergency' => [ 'detected' => true, 'data' => $emergency ], 'symptoms' => $symptoms, 'results' => [] ];
        }

        $results = $this->conditionMatcher->match($symptoms);
        return [ 'success' => true, 'emergency' => [ 'detected' => (bool) $emergency, 'data' => $emergency ], 'symptoms' => $symptoms, 'results' => $results ];
    }
}