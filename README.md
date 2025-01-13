# Sistem Sekolah Terintegrasi(SST)

Aplikasi Sistem Sekolah Terintegrasi adalah suatu proyek yang bertujuan untuk mengintegrasikan seluruh aktivitas pembelajaran ,ekstrakurikuler,peminjaman buku,managemen guru dan siswa,serta memiliki lms serta ujian yang dapat dicetak dalam output raport semester.Aplikasi ini dikembangkan menggunakan framework Laravel 11 dan didesain untuk melakukan managemen aktivisan yang ada di sekolahan.

> [Instlasi & Cara penggunaan](#cara-penggunaan)

## Fitur Utama

>[!NOTE]
>
>## Framework dan Library Yang Digunakan
>
>- [Laravel 11](https://laravel.com/)
>- [Tailwind CSS](https://tailwindcss.com/)
>- [Flowbite Admin Template](https://flowbite.com/)
>- [Laravel Excel](https://laravel-excel.com/)
>- [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)

## Cara Penggunaan

> [!CAUTION]
>
> ### Persyaratan
>
> - [Composer](https://getcomposer.org/).
> - PHP 8.1+ dan MySQL/MariaDB atau menggunakn [laragon](https://laragon.org/) untuk lebih mudahnya.
>
> ### Instalasi
>
> - Clone/Download source code proyek ini.
>
> - Pastikan sudah masuk ke folder yang sesuai,dengan menulis di terminal:
> 
>   ```shell
>   cd PPL
>   ```
>
> - Install Depedencies yang diperlukan dengan menjalankan perintah di terminal :
>   ```shell
>   composer install
>   ```
> 
> - Jika belum terdapat file `.env`, copy file `.env example` dan ubah menjadi `.env`
> 
> - Generate key pada code agar web dapat dijalankan dengan menulis di terminal :
> 
>   ```shell
>   php artisan key:generate
>   ```
>   
> - Install Dependencies yang lain unyuk tampilan dengan menjalankan perintah di terminal :
> 
>   ```shell
>   npm install
>   ```
>
> - jangan lupa untuk migrasi dan seeder databse dengan menjalankan perintah di terminal :
>   ```shell
>   php artisan migrate --seed
>   ```
> - jika ingin memuat ulang database ke bentuk semula dapat menggunakan perinta :
>   ```shell
>   php artisan migrate:fresh --seed
>   ```
> - untuk menjalankan perlu menulis perintah di dua terminal yang berbeda yaitu:
>   ```shell
>   php artisan serve
>   ```
> - dan
>   ```shell
>   npm run dev
>   ```
>
> - Klik kanan localhost yang telah didapat dari perintah php artisan serve
> - jangan lupa bahwa laragion/XAMPP harus menyala untuk connect ke PHPmyadmin
> - jika terdapat eror mungkin perlu menjalankan perintah :
>   ```shell
>   composer update
>   ```
>
> - untuk fitur login with google perlu menggunakan protocol HTTPS,jika tidak akan eror.
> - Wa gateway menggunanakn Twiliio perlu adanya penyesuianga agar berhasil
> 1. Chat nomor +14155238886
> 2. Ketik 'join weak-gold' (tanpa tanda petik)
> 3. Nanti ada keterangan successfully 

> - Untuk menjalankan server twiliio gunakan perintah berikut pada terminal yang berbeda
>   ```shell
>   php artisan queue:listen
>   ```
> - Dan
>  ```shell
>   php artisan schedule:work
>  ```

> [!TIP]
> - Untuk data dapat dilihat pada folder Data untuk import excel
> - email darus terdaftar di gmail dan database untuk bisa login
> - import excel memiliki formatnya sendiri sehingga tidak bisa sembarangan
> - nomer wa harus terdaftar lewat chat twillio terlebih dahulu baru bisa di hubungi nomernya sesuai dengan database
> - jika ingin merubah database menggunakan selain MUSQL dapat dilakukan di `.env`


## Kesimpulan 
Dengan Aplikasi web Sistemn Sekolah Terintegrasi ini, diharapkan sekolah menjadi lebih modern dan juga lebih efisien. Proyek ini dapat diadaptasi dan dikembangkan lebih lanjut sesuai dengan kebutuhan sekolah.