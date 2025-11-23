# XOR-CRUD-XAMPP (Simple demo)

Repository ini berisi aplikasi web sederhana (PHP) yang menunjukkan CRUD (Create, Read, Update, Delete)
terhadap data pesan yang disimpan ke MySQL, dengan enkripsi simetris **Stream XOR**.
Dirancang untuk dijalankan di **XAMPP** (Windows) atau lingkungan PHP+MySQL lainnya.

## Struktur
- `index.php` - halaman utama + logika CRUD
- `config.php` - konfigurasi koneksi database (sesuaikan bila perlu)
- `xor_functions.php` - fungsi encrypt/decrypt XOR + base64
- `dump_mysql.sql` - file SQL untuk membuat database & tabel
- `screenshot.png` - screenshot UI (disertakan)

## Cara menjalankan (XAMPP)
1. Pastikan XAMPP terinstall. Jalankan **Apache** dan **MySQL**.
2. Copy folder `xor_crud_xampp_repo` ke `C:\xampp\htdocs\` atau ekstrak ZIP ke sana.
3. Import `dump_mysql.sql` lewat phpMyAdmin (http://localhost/phpmyadmin) atau:
   ```
   mysql -u root < dump_mysql.sql
   ```
4. Buka browser ke:
   ```
   http://localhost/xor_crud_xampp_repo/
   ```
   atau jika folder bernama lain, sesuaikan path.
5. Halaman akan menampilkan form untuk membuat pesan. Secara default aplikasi menggunakan kunci XOR `sekolah123`
   yang berada di `index.php` (line comment). Untuk penggunaan aman, simpan kunci di tempat lebih aman.

## Catatan keamanan
- XOR dengan kunci pendek **tidak** aman untuk produksi. Gunakan AES/GCM atau ChaCha20 untuk keamanan nyata.
- Jangan menyimpan kunci di file yang dapat diakses publik.
- Gunakan prepared statements (sudah dipakai di INSERT/UPDATE di file ini).

## Menambahkan/sesuaikan
- Ubah user/password database di `config.php` sesuai XAMPP Anda.
- Jika ingin meminta kunci dari user, ubah logika agar kunci tidak hardcoded.

--- 

Buat pertanyaan jika Fitri ingin saya:
- Buatkan repo GitHub langsung (minta token atau saya bantu langkah push)
- Ubah UI agar persis seperti screenshot
- Tambah fitur login sederhana
