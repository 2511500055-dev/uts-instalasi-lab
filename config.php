<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "instalasi_lab";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    error_log("Koneksi database gagal: " . mysqli_connect_error());
    http_response_code(500);
    echo json_encode([
        "status"  => false,
        "message" => "Terjadi kesalahan pada server",
        "data"    => null
    ]);
    exit;
}

mysqli_set_charset($koneksi, "utf8mb4");