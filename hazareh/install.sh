#!/bin/bash
# ============================================================
# اسکریپت نصب سریع — هنرستان هزاره صنعت
# اجرا: bash install.sh
# ============================================================
set -e

echo "🏭 نصب هنرستان هزاره صنعت ..."

# 1. نصب وابستگی‌های PHP
echo "📦 نصب Composer packages..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 2. تنظیمات محیط
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
  echo "✅ فایل .env ساخته شد"
else
  echo "⚠️  فایل .env از قبل موجود است"
fi

# 3. دیتابیس
echo ""
echo "📋 لطفاً تنظیمات دیتابیس را در .env وارد کنید:"
echo "   DB_DATABASE=hazareh_db"
echo "   DB_USERNAME=root"
echo "   DB_PASSWORD="
echo ""
read -p "آماده‌اید؟ (y/n): " confirm
if [ "$confirm" != "y" ]; then exit 0; fi

# 4. Migration و Seed
php artisan migrate --seed --force
echo "✅ دیتابیس آماده شد"

# 5. Storage link
php artisan storage:link
echo "✅ Storage linked"

# 6. Cache clear
php artisan config:clear
php artisan cache:clear

echo ""
echo "🎉 نصب کامل شد!"
echo "   اجرا: php artisan serve"
echo "   آدرس: http://127.0.0.1:8000"
echo "   مدیر: کد ملی 0000000000 / رمز ChangeMe@123"
