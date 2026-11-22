<?php

/*
| Starter content for the 6 menu departments (editable later in Admin → Departments).
*/

return [
    [
        'slug' => 'general-medicines',
        'name' => 'General Medicines',
        'icon' => 'bi-clipboard2-pulse',
        'image' => 'assets/img/specialities/general-medicine.webp',
        'tagline' => 'Accurate diagnosis. Complete, family-first care.',
        'short' => 'Diagnosis and treatment of fever, infections, BP, thyroid, lifestyle diseases and other everyday illnesses for adults and the elderly.',
        'overview' => [
            'The Department of General Medicine at ANP Nursing Home is the first point of care for most of our patients. Our physicians evaluate symptoms carefully, order only the investigations that are needed and plan treatment that is clear, effective and affordable.',
            'With an in-house laboratory, pharmacy, ECG, X-ray and ultrasound, most tests and treatment happen under one roof. When a patient needs admission, our 24×7 ward and ICU teams continue the same plan without delay.',
        ],
        'services' => [
            'Fever, dengue, typhoid & viral infections',
            'High blood pressure & thyroid disorders',
            'Respiratory infections, asthma & COPD',
            'Gastritis, acidity & liver problems',
            'Elderly & preventive health care',
            'In-patient care with 24×7 monitoring',
        ],
        'faqs' => [
            ['q' => 'Do I need an appointment to see the physician?', 'a' => 'Walk-ins are welcome, but booking an appointment by phone or the form on this page helps you avoid waiting.'],
            ['q' => 'Are lab tests available on the same day?', 'a' => 'Yes. Our in-house lab handles routine and specialised tests, and home sample collection is also available.'],
        ],
    ],
    [
        'slug' => 'diabetologist',
        'name' => 'Diabetologist',
        'icon' => 'bi-droplet-half',
        'image' => 'assets/img/specialities/diabetology.webp',
        'tagline' => 'Better sugar control. Fewer complications.',
        'short' => 'Complete diabetes care – Type 1, Type 2 and gestational diabetes, insulin management, diet guidance and screening for complications.',
        'overview' => [
            'Diabetes care is a long journey, and our Diabetic, Cardio & Renal Centre is built to walk it with you. Led by Dr. K. Arul, MD, the team focuses on stable sugar control and on preventing damage to the heart, kidneys, eyes and feet.',
            'Each patient receives a personalised plan covering medicines or insulin, diet, exercise and regular follow-up, with HbA1c, kidney and cardiac checks done in-house.',
        ],
        'services' => [
            'Type 1, Type 2 & gestational diabetes',
            'Insulin initiation & dose adjustment',
            'HbA1c, kidney & lipid profile monitoring',
            'Diabetic foot & neuropathy screening',
            'Diet & lifestyle counselling',
            'Diabetic Master Health Checkup',
        ],
        'faqs' => [
            ['q' => 'How often should I check my HbA1c?', 'a' => 'Most people with diabetes should check HbA1c every 3 months, or as advised by your diabetologist.'],
            ['q' => 'Is there a health checkup package for diabetes?', 'a' => 'Yes. The Diabetic Master Health Checkup covers blood sugar, CBC, kidney function and more.'],
        ],
    ],
    [
        'slug' => 'critical-care-specialty',
        'name' => 'Critical Care Specialty',
        'icon' => 'bi-activity',
        'image' => null,
        'tagline' => '24×7 ICU with an expert critical-care team.',
        'short' => 'Round-the-clock ICU and emergency care for heart attack, stroke, poisoning, severe infections and post-operative patients.',
        'overview' => [
            'Our Critical Care unit is equipped and staffed 24 hours a day for life-threatening conditions. Ventilators, defibrillators, central patient monitoring and uninterrupted oxygen supply support every bed.',
            'The team works closely with the emergency department and the ambulance service so that critically ill patients receive treatment within the first golden hour.',
        ],
        'services' => [
            '24×7 emergency & ICU admission',
            'Heart attack & stroke management',
            'Poisoning & snake-bite care',
            'Ventilator & non-invasive ventilation support',
            'Sepsis & severe infection management',
            'Post-operative intensive care',
        ],
        'faqs' => [
            ['q' => 'Is the ICU open at night and on holidays?', 'a' => 'Yes. Emergency and ICU services are available 24 hours a day, 7 days a week.'],
            ['q' => 'How do I call the ambulance?', 'a' => 'Call our 24/7 emergency number +91 88707 83938.'],
        ],
    ],
    [
        'slug' => 'obstetrics',
        'name' => 'Obstetrics',
        'icon' => 'bi-gender-female',
        'image' => 'assets/img/specialities/obstetrics-gynaecology.webp',
        'tagline' => 'Safe pregnancy. Happy deliveries.',
        'short' => 'Pregnancy care from the first visit to delivery and after – antenatal checkups, scans, normal and caesarean delivery and newborn care.',
        'overview' => [
            'Led by Dr. R. Nallichandra, MD, our obstetrics team cares for mothers through every trimester with regular checkups, ultrasound scans and lab tests in the same building.',
            'Our labour room and operation theatre are ready around the clock for normal and caesarean deliveries, with neonatal and paediatric support for the baby.',
        ],
        'services' => [
            'Antenatal checkups & pregnancy scans',
            'High-risk pregnancy care',
            'Normal delivery & painless labour guidance',
            'Caesarean section',
            'Postnatal & breastfeeding support',
            'Newborn care & vaccination',
        ],
        'faqs' => [
            ['q' => 'When should I have my first pregnancy visit?', 'a' => 'As soon as your pregnancy test is positive, ideally within the first 6–8 weeks.'],
            ['q' => 'Are scans done in the hospital?', 'a' => 'Yes, ultrasound and pregnancy scans are available in-house.'],
        ],
    ],
    [
        'slug' => 'gynaecology',
        'name' => 'Gynaecology',
        'icon' => 'bi-flower1',
        'image' => 'assets/img/specialities/obstetrics-gynaecology.webp',
        'tagline' => 'Women’s health at every stage of life.',
        'short' => 'Care for menstrual problems, PCOD, fibroids, infertility, menopause and gynaecological surgery including laparoscopic procedures.',
        'overview' => [
            'The Gynaecology department offers confidential, compassionate care for women from adolescence to menopause. Common concerns such as irregular periods, PCOD and white discharge are evaluated with the help of in-house scans and lab tests.',
            'Our gynaecologists also manage infertility and perform open and laparoscopic surgeries for fibroids, ovarian cysts and uterine conditions.',
        ],
        'services' => [
            'Irregular / heavy periods & PCOD',
            'Infertility evaluation & treatment',
            'Fibroids & ovarian cysts',
            'Laparoscopic gynaecological surgery',
            'Menopause care',
            'Cervical cancer screening',
        ],
        'faqs' => [
            ['q' => 'Do you offer infertility treatment?', 'a' => 'Yes. Dr. R. Nallichandra is an infertility specialist and offers evaluation and treatment for couples.'],
        ],
    ],
    [
        'slug' => 'nephrology',
        'name' => 'Nephrology',
        'icon' => 'bi-droplet',
        'image' => null,
        'tagline' => 'Protecting your kidneys for life.',
        'short' => 'Diagnosis and treatment of kidney disease, kidney stones and urinary infections, with dialysis care under expert monitoring.',
        'overview' => [
            'Kidney disease often develops silently, especially in people with diabetes or high blood pressure. Our Nephrology service focuses on early detection with simple blood and urine tests, followed by treatment that slows progression.',
            'For patients who need it, our dialysis unit provides safe and comfortable sessions with continuous monitoring by trained technicians.',
        ],
        'services' => [
            'Chronic kidney disease (CKD) care',
            'Dialysis',
            'Diabetic & hypertensive kidney disease',
            'Kidney stones & urinary infections',
            'Electrolyte imbalance management',
            'Kidney function screening',
        ],
        'faqs' => [
            ['q' => 'Who should get a kidney function test?', 'a' => 'People with diabetes, high blood pressure, a family history of kidney disease or swelling of the legs should be screened regularly.'],
        ],
    ],
];
