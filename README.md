# UTS/UAS Instalasi Lab

### 505http
<p>Jeffrey Deryata [2511500007]</p>
<p>Widya Serena Mulyaputeri [2511500020]</p>
<p>Monika Aldesia Plaron [2511500030]</p>
<p>Aditya Isani Wijaya [2511500055]</p>



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
            <td>GET All</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php
            </td>
            <td>-</td>
            <td>JSON berisi seluruh data instalasi</td>
        </tr>
        <tr>
            <td>GET By no_instalasi</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=1
            </td>
            <td>-</td>
            <td>JSON berisi data berdasarkan nomor instalasi</td>
        </tr>
        <tr>
            <td>GET Search</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?search=widya
            </td>
            <td>-</td>
            <td>JSON berisi hasil pencarian data instalasi</td>
        </tr>
        <tr>
            <td>GET Page &amp; Limit</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?page=1&amp;limit=5
            </td>
            <td>-</td>
            <td>JSON berisi data sesuai halaman dan batas data</td>
        </tr>
        <tr>
            <td>POST</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php
            </td>
            <td>
                <pre>{
  "id_mahasiswa": 1,
  "id_software": 2,
  "status": "Menunggu"
}</pre>
            </td>
            <td>JSON berisi pesan berhasil dan no_instalasi baru</td>
        </tr>
        <tr>
            <td>PUT</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=1
            </td>
            <td>
                <pre>{
  "id_mahasiswa": 1,
  "id_software": 2,
  "status": "Selesai"
}</pre>
            </td>
            <td>JSON berisi pesan data berhasil diperbarui</td>
        </tr>
        <tr>
            <td>DELETE</td>
            <td>
                http://localhost/pdcs-uts/uts-instalasi-lab/api/instalasi.php?no_instalasi=1
            </td>
            <td>-</td>
            <td>JSON berisi pesan data berhasil dihapus</td>
        </tr>
    </tbody>
</table>
