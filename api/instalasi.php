<?php
require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        //echo "ini adalah metode GET";

        // GET ID
        if (isset($_GET['no_instalasi'])) {

            $no_instalasi = (int) ($_GET['no_instalasi'] ?? 0);

            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT
        f.no_instalasi,
        f.id_mahasiswa,
        m.nama_mahasiswa AS nama_mahasiswa,
        f.id_software,
        s.nama_software AS nama_software,
        f.created_at,
        f.status

    FROM form_instalasi f

    LEFT JOIN mahasiswa m
        ON f.id_mahasiswa = m.id_mahasiswa

    LEFT JOIN software s
        ON f.id_software = s.id_software

    WHERE f.no_instalasi = ?"
            );

            mysqli_stmt_bind_param($stmt, 'i', $no_instalasi);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                queryError($koneksi);
            }

            $data = mysqli_fetch_assoc($result);

            if (!$data) {
                sendResponse(
                    false,
                    "Data instalasi tidak ditemukan",
                    null,
                    404
                );
            }

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        //SEARCH
        if (isset($_GET['search'])) {

            $search = $_GET['search'] ?? "";
            $term = "%" . $search . "%";

            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT
                    f.no_instalasi,
                    f.id_mahasiswa,
                    m.nama_mahasiswa AS nama_mahasiswa,
                    f.id_software,
                    s.nama_software AS nama_software,
                    f.created_at,
                    f.status

                FROM form_instalasi f

                LEFT JOIN mahasiswa m
                     ON f.id_mahasiswa = m.id_mahasiswa

                LEFT JOIN software s
                    ON f.id_software = s.id_software

                    WHERE m.nama_mahasiswa LIKE ?
                    OR s.nama_software LIKE ?
                    OR f.status LIKE ?
                    ORDER BY f.no_instalasi DESC"
            );

            mysqli_stmt_bind_param($stmt, "sss", $term, $term, $term);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                sendResponse(false, "Query gagal: " . mysqli_error($koneksi), null, 500);
            }

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (empty($data)) {
                sendResponse(false, "Data Instalasi tidak ditemukan", null, 404);
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

            $offset = ($page - 1) * $limit;

            $query = "SELECT
                    f.no_instalasi,
                    f.id_mahasiswa,
                    m.nama_mahasiswa AS nama_mahasiswa,
                    f.id_software,
                    s.nama_software AS nama_software,
                    f.created_at,
                    f.status

                FROM form_instalasi f

                LEFT JOIN mahasiswa m
                     ON f.id_mahasiswa = m.id_mahasiswa

                LEFT JOIN software s
                    ON f.id_software = s.id_software
                    ORDER BY f.no_instalasi DESC
                    LIMIT $limit OFFSET $offset";

            $result = mysqli_query($koneksi, $query);

            if (!$result) {
                sendResponse(
                    false,
                    "Query gagal: " . mysqli_error($koneksi),
                    null,
                    500
                );
            }

            $data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            sendResponse(
                true,
                "Data berhasil diambil",
                $data,
                200
            );
        }

        $query = "SELECT
                    f.no_instalasi,
                    f.id_mahasiswa,
                    m.nama_mahasiswa AS nama_mahasiswa,
                    f.id_software,
                    s.nama_software AS nama_software,
                    f.created_at,
                    f.status

                FROM form_instalasi f

                LEFT JOIN mahasiswa m
                     ON f.id_mahasiswa = m.id_mahasiswa

                LEFT JOIN software s
                    ON f.id_software = s.id_software";
        $result = mysqli_query($koneksi, $query);
        
        if(!$result) sendResponse(false, "Query gagal: " . mysqli_error($koneksi), null, 500);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        sendResponse(true, "berhasil", $data, 200);
        
        break;

    case 'POST':

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['id_mahasiswa']) || !isset($input['id_software']) || !isset($input['status'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $id_mahasiswa = (int) $input['id_mahasiswa'];
        $id_software = (int) $input['id_software'];
        $status = $input['status'];

        $stmt = mysqli_prepare($koneksi, "INSERT INTO form_instalasi (id_mahasiswa, id_software, created_at, status) VALUES (?,?, NOW(),?)");
        mysqli_stmt_bind_param($stmt, "iis", $id_mahasiswa, $id_software, $status);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Data telah berhasil tersimpan", ["no_instalasi" => mysqli_insert_id($koneksi)], 201);
        } else {
            sendResponse(false, "Gagal menyimpan data: " . mysqli_error($koneksi), null, 500);
        }

        break;

    case 'PUT':

        $input = json_decode(file_get_contents("php://input"), true);
        
        if (!$input || !isset($input['id_mahasiswa']) || !isset($input['id_software']) || !isset($input['status'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $no_instalasi = $_GET['no_instalasi'];

        $id_mahasiswa = (int) $input['id_mahasiswa'];
        $id_software = (int) $input['id_software'];
        $status = $input['status'];

        #Cek Id Mahasiswa
        $cek_mahasiswa = mysqli_query($koneksi, "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa' ");
        if (mysqli_num_rows($cek_mahasiswa) == 0) {
            sendResponse(false, "Mahasiswa tidak ditemukan", null, 404);
        }

        #Cek apakah software exist
        $cek_software = mysqli_query($koneksi, "SELECT id_software FROM software WHERE id_software = '$id_software' ");
        if (mysqli_num_rows($cek_software) == 0) {
            sendResponse(false, "Software tidak ditemukan", null, 404);
        }

        #Update
        $query = "UPDATE form_instalasi SET id_mahasiswa = '$id_mahasiswa', id_software = '$id_software', `status` = '$status' WHERE no_instalasi = '$no_instalasi'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Diperbarui", ["no_instalasi" => $no_instalasi], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }

        break;

    case 'DELETE':

        $no_instalasi = $_GET['no_instalasi'];

        $cek_form = mysqli_query($koneksi, "SELECT no_instalasi FROM form_instalasi WHERE no_instalasi = '$no_instalasi' ");
        if (mysqli_num_rows($cek_form) == 0)
            sendResponse(false, "Form Instalasi tidak ditemukan", null, 404);

        $query = "DELETE FROM form_instalasi WHERE no_instalasi = '$no_instalasi'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Dihapus", ["no_instalasi" => $no_instalasi], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }
        break;

    default:
        sendResponse(false, "Metode tidak diizinkan", null, 405);
        break;
}
