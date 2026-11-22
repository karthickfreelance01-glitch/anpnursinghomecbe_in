<?php

/*
|--------------------------------------------------------------------------
| ANP Nursing Home – static site content
|--------------------------------------------------------------------------
| Everything shown on the website lives here, so text, numbers and
| phone numbers can be updated without touching the Blade views.
*/

return [

    'name'     => 'ANP Nursing Home',
    'tagline'  => 'Multi Speciality Hospital',
    'tamil'    => '(ANP) அனைவரும் நலம்பெற',

    'contact' => [
        'phone'        => '+91 88707 77516',
        'phone_raw'    => '+918870777516',
        'whatsapp'     => '918870777516',
        'emergency'    => '+91 88707 83938',
        'emergency_raw'=> '+918870783938',
        'pharmacy'     => '+91 88707 50222',
        'pharmacy_raw' => '+918870750222',
        'lab'          => '+91 88707 51222',
        'lab_raw'      => '+918870751222',
        'appointment'  => ['+91 88707 59916', '+91 88707 14779', '+91 88707 77516'],
        'email'        => 'anpnh12@gmail.com',
        'address'      => 'ANP Nursing Home, 8/1 Jaya Nagar, Poochiyur, Thondamuthur Road, Dheenampalayam (PO), Coimbatore – 641109.',
        'map_query'    => 'ANP Nursing Home, Poochiyur, Thondamuthur Road, Coimbatore 641109',
    ],

    'social' => [
        'facebook'  => '#',
        'instagram' => '#',
        'youtube'   => '#',
    ],

    'marquee' => '🚑 அவசர மருத்துவ சேவை – உடனடி உதவிக்கு தொடர்பு கொள்ளவும்: 📞 +91 88707 83938  •  24/7 Emergency & Ambulance  •  Pharmacy 5% Discount  •  Home Sample Collection for Lab Tests',

    'hero_slides' => [
        ['img' => 'slide-1.webp', 'alt' => 'ANP Nursing Home – Coimbatore'],
        ['img' => 'slide-2.webp', 'alt' => 'ANP Nursing Home – Your health is our priority'],
        ['img' => 'slide-3.webp', 'alt' => 'Dr. K. Arul – Diabetes, General & Critical Care Specialist'],
        ['img' => 'slide-4.webp', 'alt' => 'Dr. R. Nallichandra – Gynaecologist & Infertility Specialist'],
        ['img' => 'slide-5.webp', 'alt' => 'ANP Pharmacy'],
        ['img' => 'slide-6.webp', 'alt' => 'ANP Lab – Trusted Lab, Trusted Results'],
        ['img' => 'slide-7.webp', 'alt' => '24/7 Emergency Ambulance'],
    ],

    'about' => [
        'For over 14 years, ANP Nursing Home has been committed to delivering compassionate, reliable, and advanced healthcare to the community. Established with a vision to make quality medical care accessible to every individual, we have grown into a trusted multi-specialty healthcare centre known for our patient-first approach and clinical excellence.',
        'At ANP Nursing Home, we blend experienced medical expertise, modern facilities, and personalized care to ensure every patient receives the highest standard of treatment. Our team of skilled doctors, trained nurses, and dedicated support staff work together to create a safe, comfortable, and healing environment for all age groups.',
    ],

    'stats' => [
        ['value' => 14, 'suffix' => '+',  'label' => 'Years Of Experience', 'icon' => 'bi-award'],
        ['value' => 60, 'suffix' => '+',  'label' => 'Doctors',             'icon' => 'bi-person-badge'],
        ['value' => 1,  'suffix' => 'L+', 'label' => 'Patients Served',     'icon' => 'bi-people'],
        ['value' => 95, 'suffix' => '%',  'label' => 'Patient Satisfaction','icon' => 'bi-emoji-smile'],
    ],

    'vision' => [
        'kural' => 'நோய்நாடி நோய்முதல் நாடி அதுதணிக்கும் வாய்நாடி வாய்ப்பச் செயல்.',
        'text'  => 'என்ற வள்ளுவனின் வாக்கிற்கேற்ப நோய்களின் மூலகாரணங்களை மருத்துவத்துறையின் அறிவியல் சார்ந்த முன்னேற்றங்களை பயன்படுத்தி கண்டறிந்து அனைத்து நோயாளிகளும் நலம் பெற (ANP) வேண்டும் என்பதே எங்கள் மருத்துவமனையின் குறிக்கோளாகும்.',
    ],
    'mission' => 'மருத்துவத்துறையின் அறிவியல் சார்ந்த முன்னேற்றங்களை கிராமப்புற நோயாளிகளும் பயன்பெறும் வகையில், குறைந்த செலவில், உயர்தரமான மருத்துவ சிகிச்சையை கொண்டு சேர்ப்பதும், நோய் வராமல் காக்கும் வழிமுறைகளை மக்களுக்கு கொண்டு சென்று நோயற்ற சமூகத்தை உருவாக்க முயல்வதும் எங்கள் மருத்துவமனையின் இலக்கு ஆகும்.',

    'doctors' => [
        [
            'name'        => 'Dr. K. Arul, MD',
            'designation' => 'Chairman, ANP Nursing Home',
            'speciality'  => 'Consultant Physician & Critical Care Specialist',
            'interest'    => 'Diabetologist',
            'photo'       => 'dr-arul.webp',
        ],
        [
            'name'        => 'Dr. R. Nallichandra, MD',
            'designation' => 'Managing Director',
            'speciality'  => 'Consultant Obstetrician & Gynaecologist',
            'interest'    => 'Infertility Specialist',
            'photo'       => 'dr-nallichandra.webp',
        ],
    ],

    'surgical' => [
        ['slug' => 'general-surgery',           'name' => 'General Surgery'],
        ['slug' => 'lap-surgery',               'name' => 'Laparoscopic Surgery'],
        ['slug' => 'obstetrics-gynaecology',    'name' => 'Obstetrics & Gynaecology'],
        ['slug' => 'paediatric-surgery',        'name' => 'Paediatric Surgery'],
        ['slug' => 'surgical-gastroenterology', 'name' => 'Surgical Gastroenterology'],
        ['slug' => 'ent',                       'name' => 'ENT'],
        ['slug' => 'surgical-oncology',         'name' => 'Surgical Oncology'],
        ['slug' => 'spine-surgery',             'name' => 'Spine Surgery'],
        ['slug' => 'neuro-surgery',             'name' => 'Neuro Surgery'],
        ['slug' => 'ortho-surgery',             'name' => 'Orthopaedic Surgery'],
        ['slug' => 'plastic-surgery',           'name' => 'Plastic Surgery'],
        ['slug' => 'dentistry',                 'name' => 'Dentistry'],
        ['slug' => 'maxillofacial-surgery',     'name' => 'Maxillofacial Surgery'],
        ['slug' => 'urology',                   'name' => 'Urology'],
        ['slug' => 'vascular-surgery',          'name' => 'Vascular Surgery'],
    ],

    'medical' => [
        ['slug' => 'general-medicine',          'name' => 'General Medicine & Critical Care'],
        ['slug' => 'diabetology',               'name' => 'Diabetology'],
        ['slug' => 'cardiology',                'name' => 'Cardiology'],
        ['slug' => 'pulmonology',               'name' => 'Pulmonology'],
        ['slug' => 'neurology',                 'name' => 'Neurology'],
        ['slug' => 'paediatric',                'name' => 'Paediatrics'],
        ['slug' => 'neonatology',               'name' => 'Neonatology'],
        ['slug' => 'anaesthesiology',           'name' => 'Anaesthesiology'],
        ['slug' => 'medical-oncology',          'name' => 'Medical Oncology'],
        ['slug' => 'medical-gastroenterology',  'name' => 'Medical Gastroenterology'],
        ['slug' => 'rheumatology',              'name' => 'Rheumatology'],
        ['slug' => 'dermatology',               'name' => 'Dermatology'],
        ['slug' => 'infectious-disease',        'name' => 'Infectious Disease'],
        ['slug' => 'psychiatry',                'name' => 'Psychiatry'],
        ['slug' => 'sonology',                  'name' => 'Sonology'],
        ['slug' => 'physiotherapy',             'name' => 'Physiotherapy'],
    ],

    'why' => [
        ['title' => 'Clinical Excellence', 'icon' => 'bi-clipboard2-pulse',
         'text' => 'At ANP Hospital, clinical excellence is the foundation of our medical practice. We deliver evidence-based care supported by advanced diagnostics and modern technology. Our clinical protocols are designed to ensure precision, safety, and optimal outcomes.'],
        ['title' => 'Personalized Care', 'icon' => 'bi-heart-pulse',
         'text' => 'Every patient deserves individualized attention. We offer customized care plans tailored to each patient’s medical needs and goals, with compassion, clarity, and patient involvement in decision-making.'],
        ['title' => 'Experienced Team', 'icon' => 'bi-people',
         'text' => 'Our team comprises highly qualified doctors, skilled nurses, and dedicated support staff. With years of clinical expertise and continuous training, we ensure confident and reliable care delivery.'],
        ['title' => 'Unparalleled Patient Experience', 'icon' => 'bi-emoji-smile',
         'text' => 'Patient experience goes beyond treatment outcomes. Clear communication, timely support, and respectful care define our service — comfort, dignity, and satisfaction remain our top priorities.'],
        ['title' => 'Quality Standards', 'icon' => 'bi-shield-check',
         'text' => 'We maintain stringent quality and safety standards across all services, follow national and international guidelines, and enforce robust infection-control and patient-safety protocols.'],
    ],

    'facilities' => [
        ['title' => 'Advanced ICU & Emergency Care', 'icon' => 'bi-hospital', 'featured' => true,
         'text' => '24×7 advanced emergency and ICU care for heart attack, stroke, poisoning and other life-threatening emergencies — with ventilator facility, centralised patient monitoring, uninterrupted oxygen support and post-operative ICU care by an expert critical care team.'],
        ['title' => 'Ambulance Care', 'icon' => 'bi-truck-front',
         'text' => 'Emergency-ready ambulance service providing rapid response, safe transport, and timely medical assistance during crises.'],
        ['title' => 'CT Scan', 'icon' => 'bi-disc',
         'text' => 'High-resolution CT imaging for accurate diagnosis, faster results, and precise treatment planning using low-radiation scanning technology.'],
        ['title' => 'Defibrillator', 'icon' => 'bi-lightning-charge',
         'text' => 'High-quality defibrillators ensuring immediate cardiac support and life-saving intervention during emergencies.'],
        ['title' => 'Dialysis', 'icon' => 'bi-droplet-half',
         'text' => 'Safe, comfortable dialysis care with continuous monitoring, expert technicians, and advanced equipment.'],
        ['title' => 'Echocardiogram', 'icon' => 'bi-heart-pulse',
         'text' => 'Detailed heart imaging, accurate cardiac assessment, and expert interpretation for timely treatment decisions.'],
        ['title' => 'Insurance Support', 'icon' => 'bi-shield-plus',
         'text' => 'Cashless treatment assistance, claim guidance, and seamless processing for all major health insurance providers.'],
        ['title' => 'Lab Investigations', 'icon' => 'bi-eyedropper', 'featured' => true,
         'text' => 'All lab tests from routine to specialised investigations, on modern interfaced analysers for accurate, reliable results with the earliest turnaround — plus home sample collection.'],
        ['title' => 'Master Health Check-up', 'icon' => 'bi-clipboard2-check',
         'text' => 'Comprehensive health screening with expert evaluation to detect risks early and promote long-term wellness.'],
        ['title' => 'Obstetrics', 'icon' => 'bi-gender-female',
         'text' => 'Pregnancy and delivery care with expert specialists, safe monitoring, and mother-baby focused treatment.'],
        ['title' => 'Operation Theatre', 'icon' => 'bi-scissors',
         'text' => 'Fully equipped, sterile operation theatres with modern surgical technology for safe procedures and superior outcomes.'],
        ['title' => 'Pharmacy', 'icon' => 'bi-capsule',
         'text' => 'Quality medicines, trusted prescriptions, and fast service — with 5% discount and home delivery.'],
        ['title' => 'Physiotherapy', 'icon' => 'bi-person-arms-up',
         'text' => 'Restoring mobility, reducing pain, and improving strength with personalised exercises and advanced techniques.'],
        ['title' => 'Scopies', 'icon' => 'bi-camera-video',
         'text' => 'Advanced endoscopy and scopy procedures for accurate diagnosis and minimally invasive evaluation.'],
        ['title' => 'Hospital Software', 'icon' => 'bi-pc-display',
         'text' => 'Smart hospital software for seamless patient management, digital records, and efficient workflow.'],
        ['title' => 'Ultrasound', 'icon' => 'bi-soundwave',
         'text' => 'High-clarity ultrasound imaging for accurate diagnosis, pregnancy monitoring, and soft-tissue evaluation.'],
        ['title' => 'Vaccination', 'icon' => 'bi-bandaid',
         'text' => 'Safe, certified vaccinations for children and adults with expert guidance and complete immunisation care.'],
        ['title' => 'Ventilator', 'icon' => 'bi-lungs',
         'text' => 'Life-support ventilators offering safe, precise respiratory assistance with continuous monitoring.'],
        ['title' => 'X-Ray', 'icon' => 'bi-radioactive',
         'text' => 'Fast, clear digital X-ray imaging for bones, injuries, and internal structures with minimal radiation.'],
    ],

    'packages' => [
        ['name' => 'Diabetic Master Health Checkup', 'price' => '3,500', 'icon' => 'bi-droplet',
         'items' => ['Fasting Blood Sugar (FBS)', 'Postprandial Blood Sugar', 'Complete Blood Count (CBC)', 'Kidney Function Test']],
        ['name' => 'Cardiac Master Health Checkup', 'price' => '3,500', 'icon' => 'bi-heart-pulse', 'popular' => true,
         'items' => ['Lipid Profile', 'Cardiac Enzymes', 'Complete Blood Count', 'Kidney Function Test']],
        ['name' => 'General Health Checkup – Women Above 40', 'price' => '3,000', 'icon' => 'bi-gender-female',
         'items' => ['CBC', 'Lipid Profile', 'Liver Function Test (LFT)', 'Kidney Function Test (KFT)']],
        ['name' => 'General Master Health Checkup (Male / Female)', 'price' => '2,500', 'icon' => 'bi-person-check',
         'items' => ['CBC', 'Blood Sugar', 'Lipid Profile', 'Liver Function Test']],
    ],

    'testimonials' => [
        ['name' => 'Gokul Ravi',   'text' => 'The doctor provided exceptional care with great patience and professionalism. They explained everything clearly and made us feel comfortable and confident throughout the treatment.'],
        ['name' => 'Swetha',       'text' => 'The doctor and treatment given was fullest to the satisfaction. Diagnosis was properly done and immediate actions were taken. Insurance team also helped us a lot to get the claim.'],
        ['name' => 'Dinesh Kumar', 'text' => 'Recently my wife had done surgery for baby birth. The hospitality and nursing service was too good. They’ve taken care of everything for all four days 24/7 — cleanliness, treatment, consultation, etc.'],
    ],
];
