# 🛡️ FINAL MISSION: OPERATION "IMMUTABLE DATA"
> **Mata Kuliah:** Keamanan Perangkat Lunak 
> **Status Proyek:** 🟢 Completed & Secured

---

## 📝 Deskripsi Proyek
Proyek ini adalah implementasi sistem keamanan data pada aplikasi **Web Absensi**. Fokus utama dari "Operation Immutable Data" adalah menjaga integritas data agar bersifat *immutable* (tidak dapat diubah) dan terlindungi dari akses ilegal menggunakan kombinasi kriptografi klasik dan konsep struktur data modern.

## 👥 Identitas Kelompok 1
Berikut adalah tim di balik pengembangan sistem keamanan ini:

| No | Nama Anggota | NIM | Peran / Kontribusi |
| :--- | :--- | :--- | :--- |
| 1 | **[Isi Nama Anggota 1]** | [Isi NIM] | **Security Lead**: Implementasi Vigenere Cipher & Enkripsi Data |
| 2 | **[Alridzki Innama Nur Razzaaq]** | [234311031] | **Role B**: THE CHAIN-MASTER (Core Blockchain Engineer) |
| 3 | **[Satria Bagus Al Imanu]** | [234311054] | **Role A**: THE SENTINEL (Identity & Privacy Specialist) |

---

## 🚀 Fitur Utama Keamanan
Dalam misi ini, kami menerapkan beberapa lapis pertahanan (Defense in Depth):

1.  **Vigenere Cipher Encryption**: Mengamankan data sensitif pada level aplikasi menggunakan kunci dinamis.
2.  **Blockchain-like Integrity**: Setiap baris data absensi memiliki *hash* yang terhubung dengan data sebelumnya, memastikan data tidak bisa dimanipulasi secara diam-diam.
3.  **Encapsulated Helpers**: Logika keamanan dipisahkan ke dalam folder `app/Helpers/` untuk memudahkan audit kode.
4.  **Immutable Logs**: Sistem dirancang agar setiap perubahan atau penghapusan data akan merusak rantai verifikasi (verification chain).

## 📁 Struktur Folder Utama
* `app/Helpers/VigenereCipher.php` — Core engine untuk enkripsi dan dekripsi.
* `app/Helpers/BlockchainImplementation` — Logika pengecekan integritas data.
* `database/` — Skema database yang mendukung penyimpanan hash keamanan.

## ⚙️ Cara Instalasi & Penggunaan
1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/alridzkiinn/web-absensi.git](https://github.com/alridzkiinn/web-absensi.git)
    ```
2.  **Konfigurasi Environment:**
    Pastikan kunci enkripsi sudah diatur pada file konfigurasi sistem.
3.  **Jalankan Aplikasi:**
    Akses melalui server lokal (XAMPP/Laragon) dan coba lakukan input data absensi untuk melihat proses enkripsi berjalan.

---
**© 2025 Kelompok 1 - Keamanan Perangkat Lunak**
*Misi ini diselesaikan untuk memenuhi standar keamanan integritas data tingkat tinggi.*
