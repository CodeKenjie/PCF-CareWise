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
    'COVID-19' => [
        'urgency' => 'HIGH',
        'description' => 'Viral respiratory infection caused by SARS-CoV-2.',
        'symptoms' => [
            'fever' => 9,
            'dry cough' => 8,
            'fatigue' => 7,
            'loss of taste or smell' => 10,
            'shortness of breath' => 9,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever and pain relief',
                'type' => 'OTC',
                'warning' => 'Do not exceed recommended dose.'
            ],
            [
                'name' => 'Oral Rehydration Salts',
                'purpose' => 'Hydration support',
                'type' => 'OTC',
                'warning' => 'Important during fever and dehydration.'
            ],
        ]
    ],
    'Sinusitis' => [
        'urgency' => 'LOW',
        'description' => 'Inflammation of the sinus cavities often due to infection or allergies.',
        'symptoms' => [
            'facial pain' => 8,
            'nasal congestion' => 9,
            'headache' => 7,
            'postnasal drip' => 6,
            'reduced smell' => 5,
        ],
        'medications' => [
            [
                'name' => 'Pseudoephedrine',
                'purpose' => 'Nasal decongestion',
                'type' => 'OTC',
                'warning' => 'Avoid if you have high blood pressure.'
            ],
            [
                'name' => 'Paracetamol',
                'purpose' => 'Pain relief',
                'type' => 'OTC',
                'warning' => 'Follow dosage instructions.'
            ],
        ]
    ],
    'Gastritis' => [
        'urgency' => 'MODERATE',
        'description' => 'Inflammation of the stomach lining.',
        'symptoms' => [
            'upper abdominal pain' => 9,
            'nausea' => 7,
            'bloating' => 6,
            'loss of appetite' => 5,
            'vomiting' => 6,
        ],
        'medications' => [
            [
                'name' => 'Omeprazole',
                'purpose' => 'Reduces stomach acid production',
                'type' => 'OTC',
                'warning' => 'Long-term use should be supervised by a doctor.'
            ],
            [
                'name' => 'Antacid',
                'purpose' => 'Neutralizes stomach acid',
                'type' => 'OTC',
                'warning' => 'Avoid overuse.'
            ],
        ]
    ],
    'Asthma' => [
        'urgency' => 'HIGH',
        'description' => 'Chronic condition causing airway inflammation and breathing difficulty.',
        'symptoms' => [
            'wheezing' => 9,
            'shortness of breath' => 10,
            'chest tightness' => 8,
            'coughing at night' => 7,
        ],
        'medications' => [
            [
                'name' => 'Salbutamol Inhaler',
                'purpose' => 'Quick relief of breathing difficulty',
                'type' => 'Prescription',
                'warning' => 'Overuse may indicate uncontrolled asthma.'
            ],
            [
                'name' => 'Inhaled Corticosteroids',
                'purpose' => 'Reduce airway inflammation',
                'type' => 'Prescription',
                'warning' => 'Use regularly as prescribed.'
            ],
        ]
    ],
    'Urinary Tract Infection' => [
        'urgency' => 'MODERATE',
        'description' => 'Bacterial infection affecting the urinary system.',
        'symptoms' => [
            'burning urination' => 10,
            'frequent urination' => 9,
            'lower abdominal pain' => 7,
            'cloudy urine' => 8,
        ],
        'medications' => [
            [
                'name' => 'Trimethoprim-Sulfamethoxazole',
                'purpose' => 'Antibiotic treatment for bacterial infection',
                'type' => 'Prescription',
                'warning' => 'Take full course as prescribed.'
            ],
            [
                'name' => 'Paracetamol',
                'purpose' => 'Pain relief',
                'type' => 'OTC',
                'warning' => 'Helps manage discomfort but does not treat infection.'
            ],
        ]
    ],
    'Dengue Fever' => [
        'urgency' => 'HIGH',
        'description' => 'Mosquito-borne viral infection common in tropical regions.',
        'symptoms' => [
            'high fever' => 10,
            'severe headache' => 8,
            'joint pain' => 9,
            'rash' => 7,
            'eye pain' => 6,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever management',
                'type' => 'OTC',
                'warning' => 'Avoid NSAIDs like ibuprofen unless advised by a doctor.'
            ],
            [
                'name' => 'Oral Rehydration Salts',
                'purpose' => 'Prevent dehydration',
                'type' => 'OTC',
                'warning' => 'Important during fever recovery.'
            ],
        ]
    ],
    'Bronchitis' => [
        'urgency' => 'MODERATE',
        'description' => 'Inflammation of the bronchial tubes, often due to infection.',
        'symptoms' => [
            'persistent cough' => 10,
            'mucus production' => 8,
            'fatigue' => 6,
            'shortness of breath' => 7,
            'chest discomfort' => 6,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever and pain relief',
                'type' => 'OTC',
                'warning' => 'Follow dosage instructions.'
            ],
            [
                'name' => 'Guaifenesin',
                'purpose' => 'Helps loosen mucus',
                'type' => 'OTC',
                'warning' => 'Drink plenty of water.'
            ],
        ]
    ],
    'Pneumonia' => [
        'urgency' => 'HIGH',
        'description' => 'Infection causing inflammation of the air sacs in one or both lungs.',
        'symptoms' => [
            'fever' => 9,
            'chest pain' => 8,
            'cough with phlegm' => 9,
            'shortness of breath' => 10,
            'fatigue' => 7,
        ],
        'medications' => [
            [
                'name' => 'Antibiotics',
                'purpose' => 'Treat bacterial infection',
                'type' => 'Prescription',
                'warning' => 'Must be prescribed by a doctor.'
            ],
            [
                'name' => 'Paracetamol',
                'purpose' => 'Reduce fever and discomfort',
                'type' => 'OTC',
                'warning' => 'Do not exceed recommended dose.'
            ],
        ]
    ],
    'Tonsillitis' => [
        'urgency' => 'MODERATE',
        'description' => 'Inflammation of the tonsils, usually due to viral or bacterial infection.',
        'symptoms' => [
            'sore throat' => 10,
            'difficulty swallowing' => 9,
            'fever' => 8,
            'swollen tonsils' => 9,
            'bad breath' => 6,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Pain and fever relief',
                'type' => 'OTC',
                'warning' => 'Follow dosing guidelines.'
            ],
            [
                'name' => 'Antibiotics',
                'purpose' => 'Used if bacterial infection is confirmed',
                'type' => 'Prescription',
                'warning' => 'Do not self-medicate antibiotics.'
            ],
        ]
    ],
    'Otitis Media' => [
        'urgency' => 'MODERATE',
        'description' => 'Middle ear infection common in children but can affect adults.',
        'symptoms' => [
            'ear pain' => 10,
            'fever' => 7,
            'hearing difficulty' => 6,
            'fluid drainage from ear' => 8,
            'irritability' => 5,
        ],
        'medications' => [
            [
                'name' => 'Paracetamol',
                'purpose' => 'Pain and fever relief',
                'type' => 'OTC',
                'warning' => 'Use as directed.'
            ],
            [
                'name' => 'Antibiotics',
                'purpose' => 'Treat bacterial infection',
                'type' => 'Prescription',
                'warning' => 'Only if prescribed by a doctor.'
            ],
        ]
    ],
    'Conjunctivitis' => [
        'urgency' => 'LOW',
        'description' => 'Inflammation of the conjunctiva, commonly known as pink eye.',
        'symptoms' => [
            'red eyes' => 10,
            'itchiness' => 8,
            'watery discharge' => 7,
            'gritty sensation' => 6,
            'swollen eyelids' => 5,
        ],
        'medications' => [
            [
                'name' => 'Artificial Tears',
                'purpose' => 'Relieve eye irritation',
                'type' => 'OTC',
                'warning' => 'Maintain eye hygiene.'
            ],
            [
                'name' => 'Antihistamine Eye Drops',
                'purpose' => 'Reduce allergic symptoms',
                'type' => 'OTC',
                'warning' => 'Avoid touching dropper tip.'
            ],
        ]
    ],
    'Chickenpox' => [
        'urgency' => 'MODERATE',
        'description' => 'Highly contagious viral infection causing itchy rash and blisters.',
        'symptoms' => [
            'itchy rash' => 10,
            'fever' => 7,
            'fatigue' => 6,
            'blister-like lesions' => 10,
            'loss of appetite' => 5,
        ],
        'medications' => [
            [
                'name' => 'Calamine Lotion',
                'purpose' => 'Relieve itching',
                'type' => 'OTC',
                'warning' => 'Apply externally only.'
            ],
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever relief',
                'type' => 'OTC',
                'warning' => 'Avoid aspirin in children.'
            ],
        ]
    ],
    'Measles' => [
        'urgency' => 'HIGH',
        'description' => 'Viral infection characterized by fever and skin rash.',
        'symptoms' => [
            'high fever' => 10,
            'rash' => 9,
            'cough' => 7,
            'runny nose' => 7,
            'red eyes' => 8,
        ],
        'medications' => [
            [
                'name' => 'Vitamin A',
                'purpose' => 'Supports immune function',
                'type' => 'OTC',
                'warning' => 'Administer under medical guidance.'
            ],
            [
                'name' => 'Paracetamol',
                'purpose' => 'Fever relief',
                'type' => 'OTC',
                'warning' => 'Do not exceed recommended dose.'
            ],
        ]
    ],
    'Gastroenteritis' => [
        'urgency' => 'MODERATE',
        'description' => 'Inflammation of the stomach and intestines causing vomiting and diarrhea.',
        'symptoms' => [
            'diarrhea' => 10,
            'vomiting' => 9,
            'abdominal cramps' => 8,
            'fever' => 6,
            'dehydration' => 9,
        ],
        'medications' => [
            [
                'name' => 'Oral Rehydration Salts',
                'purpose' => 'Prevent dehydration',
                'type' => 'OTC',
                'warning' => 'Essential for fluid replacement.'
            ],
            [
                'name' => 'Loperamide',
                'purpose' => 'Reduce diarrhea frequency',
                'type' => 'OTC',
                'warning' => 'Avoid if infection is suspected with fever or blood.'
            ],
        ]
    ],
    'Anemia' => [
        'urgency' => 'MODERATE',
        'description' => 'Condition where the body lacks enough healthy red blood cells.',
        'symptoms' => [
            'fatigue' => 10,
            'pale skin' => 8,
            'dizziness' => 7,
            'shortness of breath' => 6,
            'weakness' => 9,
        ],
        'medications' => [
            [
                'name' => 'Iron Supplements',
                'purpose' => 'Increase iron levels',
                'type' => 'OTC',
                'warning' => 'Take as directed to avoid overdose.'
            ],
            [
                'name' => 'Vitamin B12',
                'purpose' => 'Support red blood cell production',
                'type' => 'OTC',
                'warning' => 'May require medical supervision.'
            ],
        ]
    ],
    'Hypoglycemia' => [
        'urgency' => 'HIGH',
        'description' => 'Condition where blood sugar levels drop too low.',
        'symptoms' => [
            'sweating' => 9,
            'shakiness' => 10,
            'confusion' => 8,
            'dizziness' => 7,
            'hunger' => 6,
        ],
        'medications' => [
            [
                'name' => 'Glucose Tablets',
                'purpose' => 'Raise blood sugar quickly',
                'type' => 'OTC',
                'warning' => 'Use immediately during episodes.'
            ],
            [
                'name' => 'Glucagon',
                'purpose' => 'Emergency blood sugar correction',
                'type' => 'Prescription',
                'warning' => 'Requires proper training.'
            ],
        ]
    ],
    'Hyperthyroidism' => [
        'urgency' => 'HIGH',
        'description' => 'Overproduction of thyroid hormones causing increased metabolism.',
        'symptoms' => [
            'weight loss' => 9,
            'rapid heartbeat' => 10,
            'anxiety' => 7,
            'sweating' => 8,
            'tremors' => 8,
        ],
        'medications' => [
            [
                'name' => 'Methimazole',
                'purpose' => 'Reduces thyroid hormone production',
                'type' => 'Prescription',
                'warning' => 'Requires doctor supervision.'
            ],
            [
                'name' => 'Beta Blockers',
                'purpose' => 'Control heart rate',
                'type' => 'Prescription',
                'warning' => 'Do not stop abruptly.'
            ],
        ]
    ], 
];