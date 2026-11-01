```php
<?php

require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

        // GET by ID
        if (isset($_GET['id_mahasiswa'])) {

            $id_mahasiswa = (int) ($_GET['id_mahasiswa'] ?? 0);

            $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa = ?");

            mysqli_stmt_bind_param($stmt, "i", $id_mahasiswa);
            mysqli_stmt_execute($stmt);
            $r = mysqli_stmt_get_result($stmt);

            if (!$r) {
                sendResponse(false, "Gagal mengambil data mahasiswa", null, 500);
            }

            $data = mysqli_fetch_assoc($r);

            if (!$data) {
                sendResponse(false, "Mahasiswa tidak ditemukan", null, 404);
            }

            sendResponse(true, "Berhasil", $data, 200);
        }

        // GET search
        if (isset($_GET['search'])) {

            $search = $_GET['search'] ?? "";
            $term = "%$search%";

            $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE nama_mahasiswa LIKE ? OR nim LIKE ? OR prodi LIKE ? ORDER BY id_mahasiswa DESC");

            mysqli_stmt_bind_param($stmt, "sss", $term, $term, $term);
            mysqli_stmt_execute($stmt);
            $r = mysqli_stmt_get_result($stmt);

            if (!$r) {
                sendResponse(false, "Gagal mencari data mahasiswa", null, 500);
            }

            $data = [];

            while ($row = mysqli_fetch_assoc($r)) {
                $data[] = $row;
            }

            sendResponse(true, "Berhasil", $data, 200);
        }

        // GET pagination
        if (isset($_GET['page']) || isset($_GET['limit'])) {

            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

            if ($page < 1) {
                $page = 1;
            }

            if ($limit < 1) {
                $limit = 10;
            }

            $offset = ($page - 1) * $limit;

            $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC LIMIT ? OFFSET ?");

            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
            mysqli_stmt_execute($stmt);
            $r = mysqli_stmt_get_result($stmt);

            if (!$r) {
                sendResponse(false, "Gagal mengambil data mahasiswa", null, 500);
            }

            $data = [];

            while ($row = mysqli_fetch_assoc($r)) {
                $data[] = $row;
            }

            sendResponse(true, "Berhasil", $data, 200);
        }

        // GET all
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");

        mysqli_stmt_execute($stmt);
        $r = mysqli_stmt_get_result($stmt);

        if (!$r) {
            sendResponse(false, "Gagal mengambil data mahasiswa", null, 500);
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($r)) {
            $data[] = $row;
        }

        sendResponse(true, "Berhasil", $data, 200);

        break;


    case 'POST':

        // POST
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['nim']) || !isset($input['nama_mahasiswa']) || !isset($input['prodi'])) {
            sendResponse(false, "field nim, nama_mahasiswa, dan prodi wajib", null, 400);
        }

        $nim = $input['nim'];
        $nama_mahasiswa = $input['nama_mahasiswa'];
        $prodi = $input['prodi'];

        // Cek NIM
        $stmt = mysqli_prepare($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE nim = ?");

        mysqli_stmt_bind_param($stmt, "s", $nim);
        mysqli_stmt_execute($stmt);
        $cekNim = mysqli_stmt_get_result($stmt);

        if (!$cekNim) {
            sendResponse(false, "Gagal memeriksa NIM mahasiswa", null, 500);
        }

        if (mysqli_num_rows($cekNim) > 0) {
            sendResponse(false, "NIM sudah terdaftar", null, 409);
        }

        // Insert mahasiswa
        $stmt = mysqli_prepare($koneksi, "INSERT INTO mahasiswa (nim, nama_mahasiswa, prodi) VALUES (?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sss", $nim, $nama_mahasiswa, $prodi);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "data tersimpan", ["id_mahasiswa" => mysqli_insert_id($koneksi)], 201);
        } else {
            sendResponse(false, "Gagal menambahkan data mahasiswa", null, 500);
        }

        break;


    case 'PUT':

        // PUT
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['nim']) || !isset($input['nama_mahasiswa']) || !isset($input['prodi'])) {
            sendResponse(false, "field nim, nama_mahasiswa, dan prodi wajib", null, 400);
        }

        if (!isset($_GET['id_mahasiswa'])) {
            sendResponse(false, "ID mahasiswa wajib diisi", null, 400);
        }

        $id_mahasiswa = (int) $_GET['id_mahasiswa'];
        $nim = $input['nim'];
        $nama_mahasiswa = $input['nama_mahasiswa'];
        $prodi = $input['prodi'];

        // Cek id mahasiswa
        $stmt = mysqli_prepare($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");

        mysqli_stmt_bind_param($stmt, "i", $id_mahasiswa);
        mysqli_stmt_execute($stmt);
        $cekMahasiswa = mysqli_stmt_get_result($stmt);

        if (!$cekMahasiswa) {
            sendResponse(false, "Gagal memeriksa data mahasiswa", null, 500);
        }

        if (mysqli_num_rows($cekMahasiswa) == 0) {
            sendResponse(false, "Mahasiswa tidak ditemukan", null, 404);
        }

        // Cek NIM
        $stmt = mysqli_prepare($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE nim = ? AND id_mahasiswa != ?");

        mysqli_stmt_bind_param($stmt, "si", $nim, $id_mahasiswa);
        mysqli_stmt_execute($stmt);
        $cekNim = mysqli_stmt_get_result($stmt);

        if (!$cekNim) {
            sendResponse(false, "Gagal memeriksa NIM mahasiswa", null, 500);
        }

        if (mysqli_num_rows($cekNim) > 0) {
            sendResponse(false, "NIM sudah terdaftar", null, 409);
        }

        // Update mahasiswa
        $stmt = mysqli_prepare($koneksi, "UPDATE mahasiswa SET nim = ?, nama_mahasiswa = ?, prodi = ? WHERE id_mahasiswa = ?");

        mysqli_stmt_bind_param($stmt, "sssi", $nim, $nama_mahasiswa, $prodi, $id_mahasiswa);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "data berhasil diperbarui", ["id_mahasiswa" => $id_mahasiswa], 200);
        } else {
            sendResponse(false, "Gagal memperbarui data mahasiswa", null, 500);
        }

        break;


    case 'DELETE':

        // DELETE
        if (!isset($_GET['id_mahasiswa'])) {
            sendResponse(false, "ID mahasiswa wajib diisi", null, 400);
        }

        $id_mahasiswa = (int) $_GET['id_mahasiswa'];

        // Cek id mahasiswa
        $stmt = mysqli_prepare($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?");

        mysqli_stmt_bind_param($stmt, "i", $id_mahasiswa);
        mysqli_stmt_execute($stmt);
        $cekMahasiswa = mysqli_stmt_get_result($stmt);

        if (!$cekMahasiswa) {
            sendResponse(false, "Gagal memeriksa data mahasiswa", null, 500);
        }

        if (mysqli_num_rows($cekMahasiswa) == 0) {
            sendResponse(false, "Mahasiswa tidak ditemukan", null, 404);
        }

        // Delete mahasiswa
        $stmt = mysqli_prepare($koneksi, "DELETE FROM mahasiswa WHERE id_mahasiswa = ?");

        mysqli_stmt_bind_param($stmt, "i", $id_mahasiswa);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "data berhasil dihapus", ["id_mahasiswa" => $id_mahasiswa], 200);
        } else {
            sendResponse(false, "Gagal menghapus data mahasiswa", null, 500);
        }

        break;


    default:

        sendResponse(false, "method tidak diizinkan", null, 405);
        break;
}

?>
```