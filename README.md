# هنرستان هزاره صنعت — راهنمای کامل نصب و راه‌اندازی

## پیش‌نیازها
- PHP 8.1+  |  MySQL 8.0+  |  Composer 2+  |  Node.js 18+  |  Flutter 3.19+
- Windows: Laragon (توصیه شده) یا XAMPP

## راه‌اندازی سریع (localhost)

```bash
# 1. استخراج زیپ
unzip hazareh-sanat.zip && cd hazareh-sanat

# 2. نصب وابستگی‌ها
composer install

# 3. تنظیمات محیط
cp .env.example .env
php artisan key:generate

# 4. ویرایش .env
DB_DATABASE=hazareh_db
DB_USERNAME=root
DB_PASSWORD=

# 5. ساخت دیتابیس
mysql -u root -e "CREATE DATABASE hazareh_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. اجرای migrations
php artisan migrate --seed

# 7. لینک storage
php artisan storage:link

# 8. اجرا
php artisan serve
# http://127.0.0.1:8000
```

**اطلاعات ورود پیش‌فرض:** کد ملی `0000000000` / رمز `ChangeMe@123`

## اپلیکیشن موبایل

```bash
cd mobile_app
# api_service.dart → baseUrl را به http://127.0.0.1:8000/api/v1 تغییر دهید
flutter pub get
flutter run
```
