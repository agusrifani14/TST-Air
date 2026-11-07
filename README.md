<div align="center">
    <h1>Tugas Besar</h1>
    <h3>II3160 - Teknologi Sistem Terintegrasi</h3>
</div>
<br>

## System Overview

Sistem penerbangan yang kami kembangkan merupakan sistem yang menyediakan jadwal penerbangan pada maskapai tersebut.

## Core Domain

<table>Core domain dari sistem penerbangan yaitu:
  <tr>
    Manajemen Jadwal Penerbangan: Mengelola jadwal penerbangan untuk setiap rute dan pesawat.
  </tr>
  <tr>
    Manajemen Kursi: Mengatur kesediaan kursi dan memberikan nomor kursi kepada penumpang.
  </tr>
  <tr>
    Manajemen Keuangan: Mengambil rekapitulasi keuangan dan melakukan penagihan.
  </tr>

## Team Members

<table>
    <tr align="center">
        <th>No.</th>
        <th>Nama</th>
        <th>NIM</th>
    </tr>
    <tr>
        <td>1.</td>
        <td>Kevin Prayoga Abdinegara</td>
        <td>18221141</td>
    </tr>
    <tr>
        <td>2.</td>
        <td>Rayhan Nugraha Putra</td>
        <td>18221149</td>
    </tr>
    <tr>
        <td>3.</td>
        <td>Hans Stephano Edbert N</td>
        <td>18221171</td>
    </tr>
</table>

## Tech Stack

- PHP
- Codeigniter 4 
- Bootstrap
- MySQL
- phpMyAdmin
- Postman
- Github dan Git
- Visual Studio Code

## How to run

### By local

1. Clone respository ini dan [repository TST-Ticket]([https://github.com/SirRay03/TST-Air](https://github.com/kevinprayoga/TST-Ticket))

2. Buka dan masuk ke dalam kedua repository di jendela yang berbeda

3. Copy content .env.example ke dalam .env

4. Download & install XAMPP [Link](https://www.apachefriends.org/)

5. Run Apache dan MySQL pada XAMP

6. Masukkan database onlyflight untuk sistem onlyflights dan database ticketing untuk sistem TST-Ticketing pada [localhost:/](http://localhost/phpmyadmin) kemudian sesuaikan dengan file .env anda

7. Setup aplikasi menggunakan command berikut

```
composer install
composer update
```

8. Jalankan aplikasi menggunakan command berikut pada terminal setiap jendela

OnlyFlights ```php spark serve --port 8080```
TST-Ticket  ```php spark serve --port 3000```

9. Service TST-Ticket berjalan pada http://localhost:3000 dan OnlyFlights berjalan pada http://localhost:8080

10. Berikut informasi akun yang dapat digunakan untuk login
```
# Login TST-Ticket
username: ilmagita
password: akujember

# Login Onlyflights
username: admin@onlyflights.18s
password: password123
```

## Features

1. **Login** - Dengan Melakukan Login, admin mampu mengakses fitur yang ada di dalamnya seperti penambahan jadwal penerbangan, melakukan check-in dan mengelola jadwal

2. **Add/Edit/Delete Penerbangan** - Admin dapat mengelola jadwal penerbangan berdasarkan yang diinginkan

3. **Add/Edit/Delete Bandara** - Admin dapat mengelola jadwal bandara berdasarkan yang diinginkan

4. **Check-in** - Admin dapat melakukan check-in untuk passenger yang ingin melakukan check-in untuk melakukan validasi dan pemberian nomor kursi

6. **Recapitulations Finance** - Admin dapat melihat rekapitulasi keuangan yang per bulan pada setiap penerbangan


## Documentation
[Documentation](https://docs.google.com/document/d/1FnAY38R1CNYTHnfE0iYoWzLuyNaCG9eu3U7hV4vAC2U/edit?usp=sharing)

*Development processes and interfaces are provided in the document.*
