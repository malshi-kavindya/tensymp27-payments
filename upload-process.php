<?php
require __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Check reference
if (!isset($_POST['reference']) || empty($_POST['reference'])) {
    echo json_encode(['success' => false, 'message' => 'Reference number is required']);
    exit();
}

// Check file
if (!isset($_FILES['receipt']) || $_FILES['receipt']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => 'Payment slip is required']);
    exit();
}

$reference = $_POST['reference'];
$fileTmp = $_FILES['receipt']['tmp_name'];
$fileName = $_FILES['receipt']['name'];
$fileType = $_FILES['receipt']['type'];

$cfile = new CURLFile($fileTmp, $fileType, $fileName);

$url = API_BASE_URL . '/api/upload-payment';
$params = [
    "reference" => $reference,
    "receipt" => $cfile
];

$responseRaw = callAPI($url, $params);
$response = json_decode($responseRaw, true);

if ($response && isset($response['success'], $response['message'])) {
    echo json_encode([
        'success' => $response['success'],
        'message' => $response['message']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $response['message']
    ]);
}


exit();

function callAPI($url, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'x-api-key: ' . API_KEY
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);

    $result = curl_exec($curl);

    if ($result === false) {
        return json_encode(['message' => curl_error($curl)]);
    }

    curl_close($curl);
    return $result;
}