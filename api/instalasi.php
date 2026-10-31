<?php
require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
    case 'GET':
        echo "ini adalah metode GET";

        // GET ID
        if (isset($_GET['id'])) {

            $id = (int) ($_GET['id'] ?? 0);

            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT
        d.kd,
        d.id_mhs,
        m.nama AS nama_mahasiswa,
        d.id_sfw,
        s.nama_software AS nama_software,
        d.created_at,
        d.status

    FROM detail_instalasi d

    LEFT JOIN mahasiswa m
        ON d.id_mhs = m.id

    LEFT JOIN software s
        ON d.id_sfw = s.id

    WHERE d.kd = ?"

            );

            mysqli_stmt_bind_param($stmt, 'i', $id);

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
                    d.kd,
                    d.id_mhs,
                    m.nama AS nama_mahasiswa,
                    d.id_sfw,
                    s.nama_software AS nama_software,
                    d.created_at,
                    d.status

                FROM detail_instalasi d

                LEFT JOIN mahasiswa m
                     ON d.id_mhs = m.id

                LEFT JOIN software s
                    ON d.id_sfw = s.id 

                    WHERE m.nama LIKE ?
                    OR s.nama_software LIKE ?
                    OR d.status LIKE ?
                    ORDER BY d.kd DESC"
            );

            mysqli_stmt_bind_param($stmt, "sss", $term, $term, $term);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                sendResponse(false, "Query gagal: " . mysqli_error($koneksi), null, 500);
            }

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (empty($data)) {
                sendResponse(false, "Data Mahasiswa tidak ditemukan", null, 404);
            }

            sendResponse(true, "Data berhasil diambil", $data, 200);
        }

        //Page/Limit

        if (isset($_GET['page']) || isset($_GET['limit'])) {

            $page = isset($_GET['page'])
                ? (int)$_GET['page']
                : 1;

            $limit = isset($_GET['limit'])
                ? (int)$_GET['limit']
                : 10;

            if ($page < 1) {
                $page = 1;
            }

            if ($limit < 1) {
                $limit = 10;
            }

            $offset = ($page - 1) * $limit;

            $query = "SELECT
                    d.kd,
                    d.id_mhs,
                    m.nama AS nama_mahasiswa,
                    d.id_sfw,
                    s.nama_software AS nama_software,
                    d.created_at,
                    d.status

                FROM detail_instalasi d

                LEFT JOIN mahasiswa m
                     ON d.id_mhs = m.id

                LEFT JOIN software s
                    ON d.id_sfw = s.id 
                    ORDER BY d.kd DESC
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
            );;
        }

        break;

    case 'POST':

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['id_mhs']) || !isset($input['id_sfw']) || !isset($input['status'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $nama = (int) $input['id_mhs'];
        $software = (int) $input['id_sfw'];
        $status = $input['status'];


        $stmt = mysqli_prepare($koneksi, "INSERT INTO instalasi (id_mhs, id_sfw, created_at, status) VALUES (?,?, NOW(),?)");
        mysqli_stmt_bind_param($stmt, "iis", $nama, $software, $status);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Data telah berhasil tersimpan", ["kd" => mysqli_insert_id($koneksi)], 201);
        } else {
            sendResponse(false, "Gagal menyimpan data: " . mysqli_error($koneksi), null, 500);
        }

        echo "ini adalah metode POST";
        break;


    case 'PUT':

        $input = json_decode(file_get_contents("php://input"), true);
        #cek apakah nim, nama, dan id_jurusan ada di dalam body yang dikirim
        if (!$input || !isset($input['id_mhs']) || !isset($input['id_sfw']) || !isset($input['status'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $id = $_GET['id'];

        $nama = (int) $input['id_mhs'];
        $software = (int) $input['id_sfw'];
        $status = $input['status'];

        #Cek Id Mahasiswa
        $cek_mahasiswa = mysqli_query($koneksi, "SELECT id FROM mahasiswa WHERE id = '$id' ");
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
        $query = "UPDATE detail_instalasi SET id_mhs = '$nama', id_sfw = '$software', `status` = '$status' WHERE kd = '$id'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Diperbarui", ["id" => $id], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }

        break;


    case 'DELETE':

        $id = $_GET['id'];

        $cek_detail = mysqli_query($koneksi, "SELECT kd FROM detail_instalasi WHERE kd = '$id' ");
        if (mysqli_num_rows($cek_detail) == 0)
            sendResponse(false, "Detail Instalasi tidak ditemukan", null, 404);

        $query = "DELETE FROM detail_instalasi WHERE kd = '$id'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Dihapus", ["kd" => $id], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }
        break;

    default:
        sendResponse(false, "Metode tidak diizinkan", null, 405);
        break;
}
