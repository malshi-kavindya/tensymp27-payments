<?php /* config.php — TENSYMP 2027 Payment Portal configuration.
        Update all "TODO" values before going live. */

// ---- Branding ----
define('CONFERENCE_NAME', 'R10 IEEE TENSYMP 2027');
define('CONFERENCE_SHORT', 'TENSYMP 2027');
define('CONFERENCE_LOGO', 'https://tensymp27.ieee.lk/TENSYMP%202027.png');
define('CONFERENCE_FAVICON', 'https://tensymp27.ieee.lk/TENSYMP%202027-crop.png');

// ---- Online payment gateway ----
define('ONLINE_PAYMENT_URL', '');

// ---- Backend API (currently pointing at the ICARC backend as a placeholder) ----
// TODO: replace with the TENSYMP backend base URL and its API key.
define('API_BASE_URL', 'https://app.icarc.lk');
define('API_KEY', 'Odr2yeXkxPhOz/WajZ3b5NXDiKAS08sdBFcDowJCEAc=');

// ---- Fee configuration (USD) ----
define('DINNER_FEE_USD', 100); // Additional Networking Functions (Gala Dinner) ticket
define('EARLY_BIRD_CUTOFF', '2027-03-15');

define('REGISTRATION_FEES_JSON', json_encode([
    'author_ieee'   => ['participation_type' => 'Author',          'member_type' => 'IEEE Member',         'ieee_member' => true,  'early_bird' => 300, 'regular' => 350],
    'author_non'    => ['participation_type' => 'Author',          'member_type' => 'IEEE Non-Member',    'ieee_member' => false, 'early_bird' => 400, 'regular' => 450],
    'student_ieee'  => ['participation_type' => 'Student',         'member_type' => 'IEEE Student Member', 'ieee_member' => true, 'early_bird' => 100, 'regular' => 120],
    'student_non'   => ['participation_type' => 'Student',         'member_type' => 'IEEE Non-Member Student', 'ieee_member' => false, 'early_bird' => 150, 'regular' => 170],
    'attendee_ieee' => ['participation_type' => 'General Attendee','member_type' => 'IEEE Member',       'ieee_member' => true,  'early_bird' => 200, 'regular' => 250],
    'attendee_non'  => ['participation_type' => 'General Attendee','member_type' => 'IEEE Non-Member',  'ieee_member' => false, 'early_bird' => 300, 'regular' => 350],
]));