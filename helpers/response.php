<?php
// helpers/response.php
// Semua endpoint mengirim JSON dengan format konsisten: {status, message, data}

function sendResponse($status, $message, $data = null, $code = 200)
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode([
        'status'  => $status,
        'message' => $message,
        'data'    => $data
    ], JSON_UNESCAPED_UNICODE);

    exit; // hentikan script supaya tidak ada output lain setelah JSON
}

// Untuk error SQL/server: detail masuk log, client hanya dapat pesan generik (pola P06)
function sendServerError($detail = '')
{
    error_log('[ERROR] ' . $detail);
    sendResponse(false, 'Terjadi kesalahan pada server', null, 500);
}