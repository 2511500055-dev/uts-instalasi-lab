<?php
// config.php
// Koneksi database + header dasar untuk semua endpoint

// Jangan tampilkan warning/error PHP ke client (pola P06), cukup catat ke log server
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Permintaan preflight CORS dari browser/aplikasi: cukup dijawab 204
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Matikan exception bawaan mysqli supaya error tidak tampil mentah ke client
mysqli_report(MYSQLI_REPORT_OFF);

// Kredensial default Laragon lokal
$host = "localhost";
$user = "root";
$pass = "";
$db   = "instalasi_lab";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    // Detail error hanya masuk log, client dapat pesan generik
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