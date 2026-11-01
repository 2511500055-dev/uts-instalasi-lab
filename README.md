# UTS/UAS PDCS

### Tema: Instalasi Lab

### Kelompok 505http
<p>Jeffrey Deryata [2511500007]
Tugas:
Nananana
</p>

<p>Widya Serena Mulyaputeri [2511500020]
Tugas:
Nananana
</p>

<p>Monika Aldesia Plaron [2511500030]
Tugas:
Nananana
</p>

<p>Aditya Isani Wijaya [2511500055]
Tugas:
Nananana
</p>



### ERD
<img src="screenshot/erd_uts.png" alt="ERD" width="800">



### Daftar Endpoint

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>Method</th>
            <th>URL</th>
            <th>Body</th>
            <th>Response</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>GET</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php
            </td>
            <td>-</td>
            <td>JSON berisi seluruh data instalasi</td>
        </tr>
        <tr>
            <td>GET</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=1
            </td>
            <td>-</td>
            <td>
                <pre>
{
"status": true,
"message": "Data berhasil diambil",
"data": {
    "no_instalasi": 1,
    "id_mahasiswa": 1,
    "nama_mahasiswa": "Widya Serena Mulyaputeri",
    "id_software": 5,
    "nama_software": "Virtual Box",
    "created_at": "2026-11-01 02:45:29",
    "status": "Selesai"
}
}
                </pre>
            </td>
        </tr>
        <tr>
            <td>GET</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?search=jef
            </td>
            <td>-</td>
            <td>
                <pre>
{
"status": true,
"message": "Data berhasil diambil",
"data": [
    {
    "no_instalasi": 3,
    "id_mahasiswa": 3,
    "nama_mahasiswa": "Jeffrey Deryata",
    "id_software": 2,
    "nama_software": "Adobe Photoshop CS6",
    "created_at": "2026-11-01 02:46:20",
    "status": "Diproses"
    }
]
}
                </pre>
            </td>
        </tr>
        <tr>
            <td>GET</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?page=1&amp;limit=3
            </td>
            <td>-</td>
            <td>
                <pre>
{
"status": true,
"message": "Data berhasil diambil",
"data": [
    {
    "no_instalasi": "6",
    "id_mahasiswa": "5",
    "nama_mahasiswa": "Ahza Seprian Pratama",
    "id_software": "5",
    "nama_software": "Virtual Box",
    "created_at": "2026-11-01 10:24:31",
    "status": "diproses"
    },
    {
    "no_instalasi": "5",
    "id_mahasiswa": "5",
    "nama_mahasiswa": "Ahza Seprian Pratama",
    "id_software": "3",
    "nama_software": "Microsoft Office",
    "created_at": "2026-11-01 02:46:57",
    "status": "Belum diproses"
    },
    {
    "no_instalasi": "4",
    "id_mahasiswa": "4",
    "nama_mahasiswa": "Aditya Ihsani Wijaya",
    "id_software": "4",
    "nama_software": "Visual Studio Code",
    "created_at": "2026-11-01 02:46:20",
    "status": "Diproses"
    }
]
}
                </pre>
            </td>
        </tr>
        <tr>
            <td>POST</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php
            </td>
            <td>
                <pre>
{
"id_mahasiswa": 1,
"id_software": 1,
"status": "Belum diproses"
}
                </pre>
            </td>
            <td>
                <pre>
{
"status": true,
"message": "Data telah berhasil tersimpan",
"data": {
    "no_instalasi": 7
}
}
                </pre>
            </td>
        </tr>
        <tr>
            <td>PUT</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=7
            </td>
            <td>
                <pre>
{
  "id_mahasiswa": 1,
  "id_software": 1,
  "status": "Diproses"
}
                </pre>
            </td>
            <td>
                <pre>
{
  "status": true,
  "message": "Data Berhasil Diperbarui",
  "data": {
    "no_instalasi": "7"
  }
}
                </pre>
            </td>
        </tr>
        <tr>
            <td>DELETE</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=7
            </td>
            <td>-</td>
            <td>
                <pre>
{
  "status": true,
  "message": "Data Berhasil Dihapus",
  "data": {
    "no_instalasi": "7"
  }
}
                </pre>
            </td>
        </tr>
    </tbody>
</table>
