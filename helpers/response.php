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

// Untuk error SQL/server: detail masuk log, client hanya dapat pesan generik (pola P06)
function serverError($detail = '')
{
    error_log("[ERROR] " . $detail);
    sendResponse(false, "Terjadi kesalahan pada server", null, 500);
}

// Nama lain untuk serverError, dipertahankan supaya kode yang memakai nama ini tidak rusak
function sendServerError($detail = '')
{
    serverError($detail);
}