<?php
// helpers/response.php
// Semua endpoint mengirim JSON dengan format konsisten: {status, message, data}

function sendResponse($status, $message, $data = null, $code = 200)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
        "status"  => $status,
        "message" => $message,
        "data"    => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Untuk error dari query biasa (mysqli_query): detail masuk log, client dapat pesan generik
function queryError($koneksi)
{
    error_log("MySQL error: " . mysqli_error($koneksi));
    sendResponse(false, "Terjadi kesalahan pada server", null, 500);
}

// Untuk error dari prepared statement atau koneksi: kirim detailnya sebagai teks.
// Detail hanya masuk log (pola P06), client tetap dapat pesan generik.
function sendServerError($detail = '')
{
    error_log("[ERROR] " . $detail);
    sendResponse(false, "Terjadi kesalahan pada server", null, 500);
}