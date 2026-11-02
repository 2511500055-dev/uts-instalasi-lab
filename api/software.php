<?php
require_once "../config.php";
require_once "../helpers/response.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        //echo "ini adalah metode GET";

        // GET ID
        if (isset($_GET['id'])) {

            $id = (int) ($_GET['id'] ?? 0);

            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT
                id_software,
                kd_software,
                nama_software
                FROM software
                WHERE id_software = ?"

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
                id_software,
                kd_software,
                nama_software
                FROM software
                
                WHERE nama_software LIKE ?
                ORDER BY id_software DESC"
            );

            mysqli_stmt_bind_param($stmt, "s", $term);
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
                id_software,
                kd_software,
                nama_software
                FROM software
                
                ORDER BY id_software DESC
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

        // GET all
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM software ORDER BY id_software DESC");

        mysqli_stmt_execute($stmt);
        $r = mysqli_stmt_get_result($stmt);

        if (!$r) {
            sendResponse(false, "Gagal mengambil data software", null, 500);
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($r)) {
            $data[] = $row;
        }

        sendResponse(true, "Berhasil", $data, 200);

        break;

      case 'POST':
            

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['kd_software']) || !isset($input['nama_software'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $kd_software = (string) $input['kd_software'];
        $nama = (string) $input['nama_software'];

 
        $stmt = mysqli_prepare($koneksi, "INSERT INTO software (kd_software, nama_software) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt, "ss", $kd_software, $nama);

        if (mysqli_stmt_execute($stmt)) {
            sendResponse(true, "Data telah berhasil tersimpan", ["id_software" => mysqli_insert_id($koneksi)], 201);
        } else 
        {
            sendResponse(false, "Gagal menyimpan data: " . mysqli_error($koneksi), null, 500);
        }

        echo "ini adalah metode POST";
        break;

     case 'PUT':

        $input = json_decode(file_get_contents("php://input"), true);
        #cek apakah nim, nama, dan id_jurusan ada di dalam body yang dikirim
         if (!$input || !isset($input['kd_software']) || !isset($input['nama_software'])) {
            sendResponse(false, "Data tidak lengkap", null, 400);
        }

        $id =(int) ($_GET['id'] ?? 0);

        $kd_software = (string) $input['kd_software'];
        $nama = (string) $input['nama_software'];

       
    $cek_id = mysqli_query($koneksi, "SELECT id_software FROM software WHERE id_software = '$id' ");
    if (mysqli_num_rows($cek_id) == 0) {
        sendResponse(false, "ID Software tidak ditemukan", null, 404);
    }

        #Update
        $query = "UPDATE software SET kd_software = '$kd_software', nama_software = '$nama' WHERE id_software = '$id'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Diperbarui", ["id_software" => $id], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }

        break;


    case 'DELETE':

        $id = $_GET['id'];

        $cek_form = mysqli_query($koneksi, "SELECT id_software FROM software WHERE id_software = '$id' ");
        if (mysqli_num_rows($cek_form) == 0)
            sendResponse(false, "Form Instalasi tidak ditemukan", null, 404);

        $query = "DELETE FROM software WHERE id_software = '$id'";

        if (mysqli_query($koneksi, $query)) {
            sendResponse(true, "Data Berhasil Dihapus", ["id_software" => $id], 200);
        } else {
            sendResponse(false, mysqli_error($koneksi), null, 500);
        }
        break;

    default:
        sendResponse(false, "Metode tidak diizinkan", null, 405);
        break;
}



