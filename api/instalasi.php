<?php
// api/instalasi.php
// Endpoint A: GET all, GET by id, search, pagination (hasil JOIN)
// POST -> Anggota 3 | PUT & DELETE -> Anggota 4

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers/response.php';

$method = $_SERVER['REQUEST_METHOD'];

// Query dasar (JOIN) dipakai bersama oleh semua jenis GET
$baseSelect = "SELECT d.kd, m.nim, m.nama AS nama_mahasiswa,
                      s.kd_software, s.nama_software,
                      d.created_at, d.status
               FROM detail_instalasi d
               JOIN mahasiswa m ON d.id_mhs = m.id
               JOIN software s ON d.id_sfw = s.id";

switch ($method) {

    case 'GET':

        // ---------- GET BY ID ----------
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Hanya angka positif yang diterima (1' OR 1=1 -- ditolak 400)
            if (!is_string($id) || !ctype_digit($id) || (int)$id <= 0) {
                sendResponse(false, "ID tidak valid", null, 400);
            }
            $id = (int)$id;

            $stmt = mysqli_prepare($koneksi, $baseSelect . " WHERE d.kd = ?");
            if (!$stmt) {
                sendServerError(mysqli_error($koneksi));
            }
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (!mysqli_stmt_execute($stmt)) {
                sendServerError(mysqli_stmt_error($stmt));
            }

            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if (!$data) {
                sendResponse(false, "Data instalasi tidak ditemukan", null, 404);
            }

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        // ---------- SEARCH ----------
        // Kosong = tampilkan semua. Joker % ditempel di PHP, bukan di query.
        $search = (isset($_GET['search']) && is_string($_GET['search']))
            ? trim($_GET['search']) : "";
        $term = "%" . $search . "%";

        $sql = $baseSelect . " WHERE (m.nama LIKE ?
                                  OR m.nim LIKE ?
                                  OR s.nama_software LIKE ?)
                               ORDER BY d.kd DESC";
        $types  = "sss";
        $params = [$term, $term, $term];

        // ---------- PAGE / LIMIT ----------
        if (isset($_GET['page']) || isset($_GET['limit'])) {
            $page  = isset($_GET['page'])  ? (int)$_GET['page']  : 1;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

            if ($page < 1)    $page = 1;
            if ($limit < 1)   $limit = 10;
            if ($limit > 100) $limit = 100;

            $offset = ($page - 1) * $limit;

            $sql    .= " LIMIT ? OFFSET ?";
            $types  .= "ii";
            $params[] = $limit;
            $params[] = $offset;
        }

        // ---------- GET ALL (+ search / pagination bila ada) ----------
        $stmt = mysqli_prepare($koneksi, $sql);
        if (!$stmt) {
            sendServerError(mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (!mysqli_stmt_execute($stmt)) {
            sendServerError(mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);

        sendResponse(true, "Data berhasil diambil", $data, 200);
        break;

    // case 'POST':   -> dikerjakan Anggota 3
     case 'PUT':

        $input = json_decode(file_get_contents("php://input"), true);
        #cek apakah nim, nama, dan id_jurusan ada di dalam body yang dikirim
        if (!$input || !isset($input['id_mhs']) || !isset($input['id_sfw']) || !isset($input['status'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $kd = $_GET['kd'];

        $nama = $input['id_mhs'];
        $software = $input['id_sfw'];
        $status = $input['status'];

        #Cek Id Mahasiswa
        $cek_mahasiswa = mysqli_query($koneksi, "SELECT id FROM mahasiswa WHERE id = '$kd' ");
        if (mysqli_num_rows($cek_mahasiswa) == 0) {
            sendResponse(false, "Mahasiswa tidak ditemukan", null, 404);
        }

        #Cek apakah jurusan exist
        $cek_software = mysqli_query($koneksi, "SELECT id  FROM software WHERE id = '$software' ");
        if (mysqli_num_rows($cek_software) == 0) {
            sendResponse(false, "Software tidak ditemukan", null, 404);
        }

        #Cek penggunaan NIM
        
        #Update
        $query = "UPDATE detail_instalasi SET id_mhs = '$nama', id_sfw = '$software', `status` = '$status' WHERE kd = '$kd'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Diperbarui", ["kd" => $kd], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }

        break;


    case 'DELETE':

        $kd = $_GET['kd'];

        $cek_detail = mysqli_query($koneksi, "SELECT kd FROM detail_instalasi WHERE kd = '$kd' ");
        if (mysqli_num_rows($cek_detail) == 0)
            sendResponse(false, "Detail Instalasi tidak ditemukan", null, 404);

        $query = "DELETE FROM detail_instalasi WHERE kd = '$kd'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Dihapus", ["kd" => $kd], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }
        break;

    default:
        sendResponse(false, "Metode tidak diizinkan", null, 405);
        break;
}
