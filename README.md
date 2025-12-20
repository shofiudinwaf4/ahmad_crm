# 📊 CRM Project Application

Aplikasi **CRM (Customer Relationship Management)** berbasis **Laravel** untuk mengelola Leads, Produk, Project, Reporting, serta Export laporan ke **Excel**, dengan sistem role **Sales** dan **Manager**.

---

## 🚀 Teknologi yang Digunakan
- PHP >= 8.2
- Laravel >= 11
- MySQL
- Bootstrap 5
- Maatwebsite Excel
- JavaScript (Vanilla)
- Carbon

---

## ✨ Fitur Utama
- Login & Logout
- Role Management (Sales & Manager)
- Manajemen Leads
- Manajemen Produk (khusus Manager)
- Project (mendukung lebih dari satu produk per lead)
- Approval harga otomatis
- Reporting Leads & Project
- Filter laporan:
  - Sales
  - Tanggal (single / range)
  - Status
- Export laporan ke **Excel (.xlsx)**

---

## 🖥️ Cara Menjalankan Aplikasi (Local)

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/crm-project.git
cd crm-project
```

### 2️⃣ Install Dependency
```bash
composer install
```

### 3️⃣ Copy File Environment
```bash
cp .env.example .env
```

Konfigurasi database di file `.env`:
```env
APP_NAME="CRM Project"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_project
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Generate Application Key
```bash
php artisan key:generate
```

### 5️⃣ Migrasi Database
```bash
php artisan migrate
```

Jika tersedia seeder:
```bash
php artisan db:seed
```

### 6️⃣ Jalankan Server
```bash
php artisan serve
```

Akses aplikasi melalui browser:
```
http://127.0.0.1:8000
```

---

## 👤 Akun Default (Jika Seeder Digunakan)

### Manager
```
Username : manager1
Password : password
Role     : Manager
```

### Sales
```
Username : sales1
Password : password
Role     : Sales
```

---

## 📘 Tata Cara Penggunaan Aplikasi

### 1 Login
- Masuk menggunakan username & password sesuai role
- Sistem akan otomatis mengarahkan ke dashboard

### 2️ Manajemen Leads (Sales)
- Sales dapat menambah dan mengelola lead miliknya
- Manager dapat melihat seluruh lead
- Status lead dapat diubah hingga **Deal**
- Lead akan bepindah ke halaman project bila status **Deal**

### 3️ Manajemen Produk (Manager)
- Tambah, ubah, dan hapus produk
- Produk digunakan pada saat pembuatan Project

### 4️ Project (Sales)
- Satu lead dapat memilih **lebih dari satu produk**
- Sistem otomatis menentukan status approval:
  - **Approved** → jika harga jual ≤ permintaan harga
  - **Waiting Approval** → jika harga jual > permintaan harga
- Tombol Edit akan muncul bila ada status **Reject**
- Tombol Proses Lead akan muncul bila semua status **Approved**

### 5️ Approval Project (Manager)
- Status Approval harga bisa diubah 

### 6 Customer
- Bisa lihat detail customers
- Satu customer dapat memilih **lebih dari satu layanan**
- Merubah status aktif layanan **Aktif** / **Tidak Aktif** (Manager)
- Sistem otomatis menentukan status Aktif Customer:
  - **Aktif** → jika status layanan ada yang aktif
  - **Tidak Aktif** → jika tatus layanan ada yang tidak aktif

### 6 Report
- Filter laporan berdasarkan:
  - Sales
  - Tanggal (single / range)
  - Status
- Filter dapat digunakan satu atau digabungkan

### 7 Export Excel
- Klik tombol **Export Excel**
- File akan terdownload otomatis
- Nama file mengikuti filter yang dipilih

Contoh:
```
report_project.xlsx
report_project_sales_budi.xlsx
report_project_19-12-2025_sampai_20-12-2025.xlsx
```

---

## 🔐 Hak Akses Role

| Role | Hak Akses |
|----|----|
| Sales | Mengelola lead sendiri, project, customer, dan laporan terbatas |
| Manager | Akses penuh ke customer, produk, approval project, dan reporting |

---

## 📁 Struktur Folder Penting
```
app/
 ├── Exports/
 ├── Http/
 │   ├── Controllers/
 │   ├── Middleware/
 ├── Models/
resources/
 ├── views/
public/
 ├── css/
 ├── js/
```

---


## 🧑‍💻 Author
**Nama:** Ahmad Shofiudin Firdani Wafa 
**Role:** Fullstack Web Developer  
**Tech Stack:** Laravel, MySQL, Bootstrap  

---

## 📄 License
Project ini dibuat untuk kebutuhan **technical test dan pembelajaran**.
