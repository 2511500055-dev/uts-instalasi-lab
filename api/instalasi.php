<?php
require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

// Query dasar JOIN (menampilkan nama relasi, bukan id_mhs / id_sfw)
$baseSelect = "SELECT 
                    d.kd,
                    m.nim,
                    m.nama AS nama_mahasiswa,
                    m.prodi,
                    s.kd_software,
                    s.nama_software,
                    d.status,
                    d.created_at
                FROM detail_instalasi d
                LEFT JOIN mahasiswa m ON d.id_mhs = m.id
                LEFT JOIN software s ON d.id_sfw = s.id";

switch ($method) {
    case 'GET':
        //GET ID
        if (isset($_GET['id'])) {
            $id = (int) ($_GET['id'] ?? 0);

            $stmt = mysqli_prepare($koneksi, $baseSelect . " WHERE d.kd = ?");
            if (!$stmt) {
                queryError($koneksi);
            }

            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                queryError($koneksi);
            }

            $data = mysqli_fetch_assoc($result);

            if (!$data) {
                sendResponse(false, "Data instalasi tidak ditemukan", null, 404);
            }

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        //SEARCH
        if (isset($_GET['search'])) {

            $search = $_GET['search'] ?? "";
            $term = "%" . $search . "%";

            $stmt = mysqli_prepare($koneksi, $baseSelect . "
                    WHERE m.nama LIKE ?
                    OR m.nim LIKE ?
                    OR s.nama_software LIKE ?
                    ORDER BY d.kd DESC");
            if (!$stmt) {
                queryError($koneksi);
            }

            mysqli_stmt_bind_param($stmt, "sss", $term, $term, $term);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                queryError($koneksi);
            }

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (empty($data)) {
                sendResponse(false, "Data instalasi tidak ditemukan", null, 404);
            }

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        //Page/Limit
        if (isset($_GET['page']) || isset($_GET['limit'])) {

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

            if ($page < 1) {
                $page = 1;
            }

            if ($limit < 1) {
                $limit = 10;
            }

            if ($limit > 100) {
                $limit = 100;
            }

            $offset = ($page - 1) * $limit;

            $stmt = mysqli_prepare($koneksi, $baseSelect . "
                    ORDER BY d.kd DESC
                    LIMIT ? OFFSET ?");
            if (!$stmt) {
                queryError($koneksi);
            }

            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                queryError($koneksi);
            }

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        //GET ALL
        $result = mysqli_query($koneksi, $baseSelect . " ORDER BY d.kd DESC");

        if (!$result) {
            queryError($koneksi);
        }

        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        sendResponse(true, "Data berhasil diambil", $data, 200);

        break;

    // case 'POST':   -> dikerjakan Anggota 3
    // case 'PUT':    -> dikerjakan Anggota 4
    // case 'DELETE': -> dikerjakan Anggota 4

    default:
        sendResponse(false, "Metode tidak diizinkan", null, 405);
        break;
}