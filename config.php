<?php
// config.php
// Koneksi database + header dasar untuk semua endpoint

require_once __DIR__ . '/helpers/response.php';

// Kredensial default Laragon/XAMPP lokal
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'instalasi_lab';

// Matikan exception bawaan mysqli supaya error tidak tampil mentah ke client
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    // Detail error hanya masuk log, client dapat pesan generik (pola P06)
    sendServerError('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');

// Header CORS dasar (supaya nanti bisa diakses dari aplikasi Android)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');