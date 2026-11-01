# UTS/UAS PDCS

### Tema: Instalasi Lab

### Kelompok 505http
<p>Jeffrey Deryata [2511500007]<br>
<ul>
    <li></li>
    <li></li>
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

<table>
  <tr>
    <th>File PHP</th>
    <th>Method</th>
    <th>URL</th>
    <th>Body</th>
    <th>Response</th>
  </tr>

  <!-- MAHASISWA -->
  <tr>
    <td>mahasiswa.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php</td>
    <td>-</td>
    <td>{"status":true,"message":"Berhasil","data":[{"id_mahasiswa":5,"nim":"2322500077","nama_mahasiswa":"Ahza Seprian Pratama","prodi":"Sistem Informasi"},{"id_mahasiswa":4,"nim":"2511500055","nama_mahasiswa":"Aditya Ihsani Wijaya","prodi":"Teknik Informatika"},{"id_mahasiswa":3,"nim":"2511500007","nama_mahasiswa":"Jeffrey Deryata","prodi":"Teknik Informatika"},{"id_mahasiswa":2,"nim":"2511500030","nama_mahasiswa":"Monika Aldesia Plaron","prodi":"Teknik Informatika"},{"id_mahasiswa":1,"nim":"2511500020","nama_mahasiswa":"Widya Serena Mulyaputeri","prodi":"Teknik Informatika"}]}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php?id_mahasiswa=5</td>
    <td>-</td>
    <td>{"status":true,"message":"Berhasil","data":{"id_mahasiswa":5,"nim":"2322500077","nama_mahasiswa":"Ahza Seprian Pratama","prodi":"Sistem Informasi"}}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php?search=mon</td>
    <td>-</td>
    <td>{"status":true,"message":"Berhasil","data":[{"id_mahasiswa":2,"nim":"2511500030","nama_mahasiswa":"Monika Aldesia Plaron","prodi":"Teknik Informatika"}]}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php?page=1&amp;limit=2</td>
    <td>-</td>
    <td>{"status":true,"message":"Berhasil","data":[{"id_mahasiswa":5,"nim":"2322500077","nama_mahasiswa":"Ahza Seprian Pratama","prodi":"Sistem Informasi"},{"id_mahasiswa":4,"nim":"2511500055","nama_mahasiswa":"Aditya Ihsani Wijaya","prodi":"Teknik Informatika"}]}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>POST</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php</td>
    <td>{"nim":"2677500078","nama_mahasiswa":"Nelsia Fadia Mulyaputeri","prodi":"Bisnis Digital"}</td>
    <td>{"status":true,"message":"data tersimpan","data":{"id_mahasiswa":6}}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>PUT</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php?id_mahasiswa=6</td>
    <td>{"nim":"2677500078","nama_mahasiswa":"Nelsia","prodi":"Bisnis Digital"}</td>
    <td>{"status":true,"message":"data berhasil diperbarui","data":{"id_mahasiswa":6}}</td>
  </tr>
  <tr>
    <td>mahasiswa.php</td>
    <td>DELETE</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/mahasiswa.php?id_mahasiswa=6</td>
    <td>-</td>
    <td>{"status":true,"message":"data berhasil dihapus","data":{"id_mahasiswa":6}}</td>
  </tr>

  <!-- SOFTWARE -->
  <tr>
    <td>software.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/software.php</td>
    <td>-</td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/software.php?id_software=1</td>
    <td>-</td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>GET</td>
    <td></td>
    <td>-</td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>GET</td>
    <td></td>
    <td>-</td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>POST</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/software.php</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>PUT</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/software.php?id_software=1</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>software.php</td>
    <td>DELETE</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/software.php?id_software=1</td>
    <td>-</td>
    <td></td>
  </tr>

  <!-- INSTALASI -->
  <tr>
    <td>instalasi.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php</td>
    <td>-</td>
    <td>{"status":true,"message":"berhasil","data":[{"no_instalasi":"1","id_mahasiswa":"1","nama_mahasiswa":"Widya Serena Mulyaputeri","id_software":"5","nama_software":"Virtual Box","created_at":"2026-11-01 02:45:29","status":"Selesai"},{"no_instalasi":"2","id_mahasiswa":"2","nama_mahasiswa":"Monika Aldesia Plaron","id_software":"4","nama_software":"Visual Studio Code","created_at":"2026-11-01 02:45:29","status":"Diproses"},{"no_instalasi":"3","id_mahasiswa":"3","nama_mahasiswa":"Jeffrey Deryata","id_software":"2","nama_software":"Adobe Photoshop CS6","created_at":"2026-11-01 02:46:20","status":"Diproses"},{"no_instalasi":"4","id_mahasiswa":"4","nama_mahasiswa":"Aditya Ihsani Wijaya","id_software":"4","nama_software":"Visual Studio Code","created_at":"2026-11-01 02:46:20","status":"Diproses"},{"no_instalasi":"5","id_mahasiswa":"5","nama_mahasiswa":"Ahza Seprian Pratama","id_software":"3","nama_software":"Microsoft Office","created_at":"2026-11-01 02:46:57","status":"Belum diproses"},{"no_instalasi":"6","id_mahasiswa":"5","nama_mahasiswa":"Ahza Seprian Pratama","id_software":"5","nama_software":"Virtual Box","created_at":"2026-11-01 10:24:31","status":"diproses"}]}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=1</td>
    <td>-</td>
    <td>{"status":true,"message":"Data berhasil diambil","data":{"no_instalasi":1,"id_mahasiswa":1,"nama_mahasiswa":"Widya Serena Mulyaputeri","id_software":5,"nama_software":"Virtual Box","created_at":"2026-11-01 02:45:29","status":"Selesai"}}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?search=jef</td>
    <td>-</td>
    <td>{"status":true,"message":"Data berhasil diambil","data":[{"no_instalasi":3,"id_mahasiswa":3,"nama_mahasiswa":"Jeffrey Deryata","id_software":2,"nama_software":"Adobe Photoshop CS6","created_at":"2026-11-01 02:46:20","status":"Diproses"}]}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>GET</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?page=1&amp;limit=3</td>
    <td>-</td>
    <td>{"status":true,"message":"Data berhasil diambil","data":[{"no_instalasi":"6","id_mahasiswa":"5","nama_mahasiswa":"Ahza Seprian Pratama","id_software":"5","nama_software":"Virtual Box","created_at":"2026-11-01 10:24:31","status":"diproses"},{"no_instalasi":"5","id_mahasiswa":"5","nama_mahasiswa":"Ahza Seprian Pratama","id_software":"3","nama_software":"Microsoft Office","created_at":"2026-11-01 02:46:57","status":"Belum diproses"},{"no_instalasi":"4","id_mahasiswa":"4","nama_mahasiswa":"Aditya Ihsani Wijaya","id_software":"4","nama_software":"Visual Studio Code","created_at":"2026-11-01 02:46:20","status":"Diproses"}]}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>POST</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php</td>
    <td>{"id_mahasiswa":1,"id_software":1,"status":"Belum diproses"}</td>
    <td>{"status":true,"message":"Data telah berhasil tersimpan","data":{"no_instalasi":7}}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>PUT</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=7</td>
    <td>{"id_mahasiswa":1,"id_software":1,"status":"Diproses"}</td>
    <td>{"status":true,"message":"Data Berhasil Diperbarui","data":{"no_instalasi":"7"}}</td>
  </tr>
  <tr>
    <td>instalasi.php</td>
    <td>DELETE</td>
    <td>http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=7</td>
    <td>-</td>
    <td>{"status":true,"message":"Data Berhasil Dihapus","data":{"no_instalasi":"7"}}</td>
  </tr>
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
