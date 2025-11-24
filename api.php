<?php
// Hataları görmek için (Geliştirme aşamasında açık kalsın)
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$jsonFile = 'tasks.json';

// Dosya kontrolü
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, '[]');
}

// GET: Verileri Oku
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo file_get_contents($jsonFile);
    exit;
}

// POST: Verileri Kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');

    // Gelen verinin geçerli JSON olup olmadığına bak
    $decoded = json_decode($input);

    if ($decoded !== null) {
        if (file_put_contents($jsonFile, $input)) {
            echo json_encode(['status' => 'success', 'message' => 'Kaydedildi']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Dosya yazma izni yok.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Gecersiz veri']);
    }
    exit;
}
?>