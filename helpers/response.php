<?php
function sendResponse($status, $message, $data = null, $code = 200)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
        "status"  => $status,
        "message" => $message,
        "data"    => $data
    ]);
    exit;
}

function queryError($koneksi)
{
    error_log("MySQL error: " . mysqli_error($koneksi));
    sendResponse(false, "Terjadi kesalahan pada server", null, 500);
}