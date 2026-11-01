# UTS/UAS Instalasi Lab

### 505http
<p>Jeffrey Deryata [2511500007]</p>
<p>Widya Serena Mulyaputeri [2511500020]</p>
<p>Monika Aldesia Plaron [2511500030]</p>
<p>Aditya Isani Wijaya [2511500055]</p>



### ERD
<img src="screenshot/erd_uts.png" alt="ERD" width="800">



### Daftar Endpoint
GET All (Menampilkan seluruh data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php

GET By no_instalasi (Menampilkan data berdasarkan no_instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php?no_instalasi=1

GET Search (mencari data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php?search=widya

GET Page & Limit (Pagination data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php?page=1&limit=5

POST (Menambahkan data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php

PUT (Memperbarui data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php?no_instalasi=1

DELETE (Menghapus data instalasi) <br>
http://localhost/pdcs-uts/uts-instalasi-lab/api/form_instalasi.php?no_instalasi=1