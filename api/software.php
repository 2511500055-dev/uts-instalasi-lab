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

        break;

}
