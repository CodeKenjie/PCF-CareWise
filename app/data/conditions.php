<?php

return [
    'Flu' => [
        'urgency' => 'MODERATE',
        'description' => 'Common viral resperatory illness',
        'symptoms' => [
            'fever' => 10,
            'cough' => 8,
            'fatigue' => 6,
            'body aches' => 7,
            'sore throat' => 5
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever and body pain relief',
                'type' => 'OTC',
                'warning' => 'Avoid Overdose. Follow label instruction.'
            ],
            [
                'name' => 'Ibuprofen',
                'purpose' => 'Pain and inflammation relief',
                'type' => 'OTC',
                'warning' => 'Avoid if you have stomach ulcer or kidney disease.'
            ],
            [
                'name' => 'Lagundi Syrup',
                'purpose' => 'Cough relief',
                'type' => 'Herbal',
                'warning' => 'Consult a doctor for persistent cough.'
            ],
        ]
    ],
    'Common Cold' => [
        'urgency' => 'LOW',
        'description' => 'Viral infection affecting the upper respiratory tract.',
        'symptoms' => [
            'runny nose' => 10,
            'sneezing' => 8,
            'sore throat' => 6,
            'cough' => 5,
            'mild fever' => 4,
        ],
        'medications' => [
            [
                'name' => 'Ceterizine',
                'purpose' => 'Relief for runny nose and sneezing',
                'type' => 'OTC',
                'warning' => 'May cause drowsiness'
            ],
            [
                'name' => 'Phenylephrine',
                'purpose' => 'Nasal congestion relief',
                'type' => 'OTC',
                'warning' => 'Avoid if you have high blood pressure.'
            ],
        ]
    ],
    'Migraine' => [
        'urgency' => 'LOW',
        'description' => 'Neurogical condition causing intense headaches.',
        'symptoms' => [
            'headache' => 10,
            'nausea' => 7,
            'light sensitivity' => 8,
            'vomiting' => 5,
            'blurred vision' => 4,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'headache relief',
                'type' => 'OTC',
                'warning' => 'Follow the proper dosage instructions.'
            ],
            [
                'name' => 'Ibuprofen',
                'purpose' => 'Pain relief',
                'type' => 'OTC',
                'warning' => 'Take with food to avoid stomach irritation.'
            ],
        ]
    ],   
    'Acid Reflux' => [
        'urgency' => 'LOW',
        'description' => 'Digestive condition where stomach acid irritates the esophagus.',
        'symptoms' => [
            'heartburn' => 10,
            'chest discomfort' => 6,
            'bloating' => 5,
            'nausea' => 4,
            'sour taste in mouth' => 8,
        ],
        'medications' => [
            [
                'name' => 'Antacid',
                'purpose' => 'Neutralizes stomach acid',
                'type' => 'OTC',
                'warning' => 'Avoid excessive use.'
            ],
            [
                'name' => 'Omeprazole',
                'purpose' => 'Reduces stomach acid production',
                'type' => 'OTC',
                'warning' => 'Consult doctor for long-term symptoms.'
            ],
        ]
    ],
    'Allergy' => [
        'urgency' => 'LOW',
        'description' => 'Immune system reaction to allergens.',
        'symptoms' => [
            'sneezing' => 9,
            'itchy eyes' => 8,
            'runny nose' => 7,
            'skin rash' => 6,
            'watery eyes' => 7,
        ],
        'medications' => [
            [
                'name' => 'Cetirizine',
                'purpose' => 'Allergy symptoms relief',
                'type' => 'OTC',
                'warning' => 'May cause drowsiness.'
            ],
            [
                'name' => 'Loratidine',
                'purpose' => 'Non-drowsy allergy relief',
                'type' => 'OTC',
                'warning' => 'Use as directed'
            ],
        ]
    ],
    'Diarrhea' => [
        'urgency' => 'MODERATE',
        'description' => 'Frequent loose or watery bowel movements.',
        'symptoms' => [
            'loose stool' => 10,
            'abdominal pain' => 7,
            'nausea' => 5,
            'dehydration' => 8,
            'stomach cramps' => 7,
        ],
        'medications' => [
            [
                'name' => 'Oral Rehydration Salts',
                'purpose' => 'Prevent dehydration',
                'type' => 'OTC',
                'warning' => 'Seek medical care if sever dehydration occurs.'
            ],
            [
                'name' => 'Loperamide',
                'purpose' => 'Temporary diarrhea relief',
                'type' => 'OTC',
                'warning' => 'Avoid if diarrhea includes blood or high fever.'
            ],
        ]
    ], 
    'Hypertension' => [
        'urgency' => 'HIGH',
        'description' => 'Condition involving elevated high blood pressure',
        'symptoms' => [
            'headaches' => 5,
            'dizziness' => 6,
            'blurred vision' => 7,
            'chest pain' => 8,
            'shortness of breath' => 7,
        ],
        'medications' => [
            [
                'name' => 'Amlodipine',
                'purpose' => 'Blood pressure management',
                'type' => 'Prescription',
                'warning' => 'Require doctor supervision.'
            ],
        ]
    ], 
];