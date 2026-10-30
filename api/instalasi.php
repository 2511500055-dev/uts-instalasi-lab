<?php
// api/detail_instalasi.php
// GET: semua data, detail (?id=), pencarian (?search=), pagination (?page=&limit=)
// Hasil JOIN menampilkan nama mahasiswa dan nama software, bukan id_mhs / id_sfw.

require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

        // ---------- GET DETAIL: ?id= ----------
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Hanya angka positif diterima, input seperti 1' OR 1=1 -- ditolak
            if (!is_string($id) || !ctype_digit($id) || (int)$id <= 0) {
                sendResponse(false, 'ID tidak valid', null, 400);
            }
            $id = (int)$id;

            $sql = "SELECT d.kd, m.nim, m.nama AS nama_mahasiswa,
                           s.kd_software, s.nama_software,
                           d.created_at, d.status
                    FROM detail_instalasi d
                    JOIN mahasiswa m ON d.id_mhs = m.id
                    JOIN software s ON d.id_sfw = s.id
                    WHERE d.kd = ?";

            $stmt = mysqli_prepare($koneksi, $sql);
            if (!$stmt) {
                sendServerError(mysqli_error($koneksi));
            }
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (!mysqli_stmt_execute($stmt)) {
                sendServerError(mysqli_stmt_error($stmt));
            }

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if (!$row) {
                sendResponse(false, 'Data instalasi tidak ditemukan', null, 404);
            }

            sendResponse(true, 'Detail instalasi', $row, 200);
        }

        // ---------- GET LIST: search + pagination ----------
        $search = (isset($_GET['search']) && is_string($_GET['search']))
            ? trim($_GET['search']) : '';

        $page  = isset($_GET['page'])  ? (int)$_GET['page']  : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

        if ($page < 1)    $page = 1;
        if ($limit < 1)   $limit = 10;
        if ($limit > 100) $limit = 100;

        $offset = ($page - 1) * $limit;

        // Wildcard % ditempel di PHP, bukan di dalam query
        $like = '%' . $search . '%';

        // Hitung total data untuk info pagination
        $sqlCount = "SELECT COUNT(*) AS total
                     FROM detail_instalasi d
                     JOIN mahasiswa m ON d.id_mhs = m.id
                     JOIN software s ON d.id_sfw = s.id
                     WHERE m.nama LIKE ?
                        OR m.nim LIKE ?
                        OR s.nama_software LIKE ?";

        $stmt = mysqli_prepare($koneksi, $sqlCount);
        if (!$stmt) {
            sendServerError(mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
        if (!mysqli_stmt_execute($stmt)) {
            sendServerError(mysqli_stmt_error($stmt));
        }
        $resCount = mysqli_stmt_get_result($stmt);
        $total = (int)mysqli_fetch_assoc($resCount)['total'];
        mysqli_stmt_close($stmt);

        // Ambil data sesuai halaman
        $sql = "SELECT d.kd, m.nim, m.nama AS nama_mahasiswa,
                       s.kd_software, s.nama_software,
                       d.created_at, d.status
                FROM detail_instalasi d
                JOIN mahasiswa m ON d.id_mhs = m.id
                JOIN software s ON d.id_sfw = s.id
                WHERE m.nama LIKE ?
                   OR m.nim LIKE ?
                   OR s.nama_software LIKE ?
                ORDER BY d.kd ASC
                LIMIT ? OFFSET ?";

        $stmt = mysqli_prepare($koneksi, $sql);
        if (!$stmt) {
            sendServerError(mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($stmt, 'sssii', $like, $like, $like, $limit, $offset);
        if (!mysqli_stmt_execute($stmt)) {
            sendServerError(mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
        mysqli_stmt_close($stmt);

        sendResponse(true, 'Daftar instalasi', [
            'items'       => $items,
            'page'        => $page,
            'limit'       => $limit,
            'total'       => $total,
            'total_pages' => (int)ceil($total / $limit)
        ], 200);
        break;

        
    // case 'POST':   -> dikerjakan anggota 3
    // case 'PUT':    -> dikerjakan anggota 4
    // case 'DELETE': -> dikerjakan anggota 4

    default:
        sendResponse(false, 'Metode tidak diizinkan', null, 405);
}