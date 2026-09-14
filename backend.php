<?php
require __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$postFields = [
    'paper_id'           => $_POST['paper_id'] ?? '',
    'paper_title'        => $_POST['paper_title'] ?? '',
    'registration_type'  => $_POST['registration_type'] ?? '',
    'participation_type' => $_POST['participation_type'] ?? '',
    'participation_mode' => $_POST['participation_mode'] ?? 'Physical',
    'participation_origin' => $_POST['participation_origin'] ?? '',
    'ieee_member'        => (isset($_POST['ieee_member']) && $_POST['ieee_member'] === 'IEEE Member') ? true : false,
    'ieee_member_id'     => $_POST['ieee_member_id'] ?? '',
    'days'               => $_POST['days'] ?? '',
    'dinner'             => intval($_POST['dinner_count'] ?? 0),
    'email'              => $_POST['email'] ?? '',
    'name'               => $_POST['name'] ?? '',
    'amount'             => floatval($_POST['amount'] ?? 0),
    'totalamount'        => floatval($_POST['totalamount'] ?? 0),
    'currency'           => $_POST['currency_type'] ?? 'USD',
];

$data = json_encode($postFields);

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => API_BASE_URL . '/api/payment',
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'x-api-key: ' . API_KEY,
        'Accept: application/json'
    ],
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0
]);

$response = curl_exec($curl);
$curlError = curl_error($curl);
curl_close($curl);

// If cURL failed
if ($response === false) {
    echo json_encode([
        'success' => false,
        'error' => 'Payment service is unavailable: ' . $curlError
    ]);
    exit;
}

// Decode API response
$responseData = json_decode($response, true);

// If API response is not valid JSON
if ($responseData === null) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid response from payment API',
        'raw' => $response
    ]);
    exit;
}

// If API did not return pdf_url
if (!isset($responseData['pdf_url'])) {
    echo json_encode([
        'success' => false,
        'error' => $responseData['message'] ?? 'Payment API did not return a PDF URL'
    ]);
    exit;
}

// All good
echo json_encode([
    'success' => true,
    'pdf_url' => $responseData['pdf_url']
]);