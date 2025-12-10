# MKM Travel Invoice System (Bahasa Melayu) - Tema Hitam Emas
Ringkasan: Sistem PHP + MySQL sederhana untuk mengurus customer, invois, dan resit.

**Ciri-ciri:**
- Login admin (edit credentials di `config.php`)
- Dashboard ringkas (jumlah customer, invois, belum dibayar)
- Pengurusan Customer (Tambah, Senarai)
- Pengurusan Invois (Buat, Senarai, Lihat/Print)
- Buat Resit / Rekod Pembayaran (attach ke invois)
- Tema hitam & aksen emas
- Mudah diubah: tukar nama syarikat, logo, warna dalam `config.php`

## Cara Pasang (Hosting dengan MySQL)
1. Muat naik semua fail ke server PHP (public_html atau www).
2. Buat database MySQL, contohnya nama: `mkm_invoice_db`
3. Import fail SQL `db.sql` ke dalam database (menggunakan phpMyAdmin atau command line).
4. Edit `config.php` dan masukkan `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.
5. (Optional) Tukar `COMPANY_NAME`, `COMPANY_LOGO` dan warna di `config.php`.
6. Akses laman utama: `https://yourdomain.com/index.php`

## Akaun Admin Default
- Username: admin
- Password: admin123
(Sila tukar segera di `config.php`)

## Nota PDF / Cetak
- Laman lihat invois/ resit (`view_invoice.php`) boleh dicetak ke PDF menggunakan fungsi Print di pelayar (File → Print → Save as PDF).

Jika perlukan saya untuk menukar nama syarikat, logo, atau sediakan versi yang terus deploy ke hosting, beritahu saya.
