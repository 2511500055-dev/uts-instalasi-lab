# UTS/UAS PDCS

### Tema: Instalasi Lab

### Kelompok 505http
<p>Jeffrey Deryata [2511500007]<br>
<ul>
    <li>Membuat Metode Put, Delete untuk instalasi.php dan software.php</li>
    <li>Memperbaiki Metode Get pada instalasi.php</li>
</ul>
<br>
</p>

<p>Widya Serena Mulyaputeri [2511500020]<br>
Tugas:<br>
<ul>
    <li>Buat database (scheme.sql)</li>
    <li>Buat ERD</li>
    <li>Menyusun Readme.md</li>
</ul>
<br>
</p>

<p>Monika Aldesia Plaron [2511500030]<br>
Tugas:<br>
<ul>
    <li></li>
    <li></li>
</ul>
<br>
</p>

<p>Aditya Isani Wijaya [2511500055]<br>
Tugas:<br>
<ul>
    <li></li>
    <li></li>
</ul>
<br>
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


### Cara Menjalankan


<p>1. Import Schema Database</p>
<ol>
    <li>Buka Laragon, kemudian klik Start All</li>
    <li>Buka browser dan akses http://localhost/phpmyadmin</li>
    <li>Pilih database yang akan digunakan atau buat database baru</li>
    <li>Pilih menu Import</li>
    <li>Klik Choose File, lalu pilih file database (file yang berekstensi .sql)</li>
    <li>Klik tombol Import</li>
    <li>Periksa apakah tabel mahasiswa, software, dan form_instalasi berhasil diimpor</li>
</ol>

<p>2. Menjalankan Project Menggunakan Laragon</p>
<ol>
    <li>Buka aplikasi Laragon</li>
    <li>Klik Start All untuk menjalankan Apache dan MySQL</li>
    <li>Pastikan folder project berada di dalam direktori C:\laragon\www (C: bisa sesuai dengan lokasi laragon masing-masing)</li>
    <li>Pastikan konfigurasi database pada file config.php sudah sesuai dengan database di PhpMyAdmin</li>
    <li>
        Buka browser dan akses alamat project: http://localhost/pdcs-uts/uts-instalasi-lab
    </li>
</ol>

<p>3. Pengujian API Menggunakan Thunder Client</p>
<ol>
    <li>Buka Visual Studio Code</li>
    <li>Klik ikon Thunder Client pada sidebar (instal dari menu Extension jika belum terinstal)</li>
    <li>Pilih New Request</li>
    <li>Pilih metode HTTP sesuai endpoint yang akan diuji (GET, POST, PUT, atau DELETE)</li>
    <li>Masukkan URL endpoint yang ingin diuji (contohnya dapat dilihat pada tabel daftar endpoint)</li>
    <li>Untuk metode POST dan PUT, pilih Body dan pilih JSON</li>
    <li>Masukkan data JSON sesuai kebutuhan (contohnya dapat dilihat pada tabel daftar endpoint)</li>
    <li>Klik Send untuk mengirim request</li>
    <li>Periksa hasil pengujian pada bagian Response</li>
</ol>
