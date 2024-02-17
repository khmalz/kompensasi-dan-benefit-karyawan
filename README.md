# KOMPENSASI DAN BENEFIT KARYAWAN

Ini adalah platform Kompensasi dan Benefit Karyawan yang dirancang untuk mempermudah pengelolaan tunjangan dan manfaat karyawan. Melalui website ini, karyawan dapat dengan mudah mengatur dan mengajukan permintaan pencairan tunjangan mereka.

## Fitur

-   Pengaturan tunjangan karyawan.
-   Permintaan pencairan tunjangan secara online.
-   Pengelolaan kompensasi dengan transparansi tinggi.
-   Meningkatkan kontrol atas sistem kompensasi dan manfaat.
-   Memungkinkan karyawan untuk mengambil keputusan finansial yang lebih baik.

## Jalankan Secara Lokal

**Clone**

```shell
git clone https://github.com/khmalz/kompensasi-dan-benefit-karyawan.git
```

**Go to Directory**

```shell
cd kompensasi-dan-benefit-karyawan
```

**Install Dependencies**

```shell
composer install
```

```shell
npm install
```

**Config Environment**

```shell
cp .env.example .env
```

**Generate Key**

```shell
php artisan key:generate
```

**Setting Database Config in Env**

```
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

**Migrate Database**

```shell
php artisan migrate --seed
```

**Link Storage**

```shell
php artisan storage:link
```

**Run Local Server**

```shell
php artisan serve
```

## Environment Variables

Untuk memastikan gambar yang terupload akan muncul, Anda perlu mengkonfigurasi pada file .env. Sesuaikan dengan url dan host yang dijalankan di browser anda saat menjalankan project ini (tidak ada / di ujung kanan).

contoh: `APP_URL=http://127.0.0.1:8000`

```
APP_URL
```

## Developer

-   [@khmalz](https://github.com/khmalz)
