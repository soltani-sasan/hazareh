<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Page;
use App\Models\Slider;
use App\Models\Conference;
use App\Models\ConferencePartner;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── مدیر سیستم ──────────────────────────────────────
        User::firstOrCreate(
            ['national_id' => '0000000000'],
            [
                'name' => 'مدیر سیستم',
                'email' => 'admin@hazareh.ir',
                'password' => Hash::make('ChangeMe@123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // ── کاربر نمونه مشاور ───────────────────────────────
        User::firstOrCreate(
            ['national_id' => '1111111111'],
            [
                'name' => 'مشاور هنرستان',
                'email' => 'counselor@hazareh.ir',
                'password' => Hash::make('ChangeMe@123'),
                'role' => 'counselor',
                'is_active' => true,
            ]
        );

        // ── صفحات ایستا ─────────────────────────────────────
        $pages = [
            ['slug' => 'about', 'title' => 'درباره هنرستان',
             'body' => '<p>هنرستان هزاره صنعت، اولین هنرستان جوار صنعت غرب کشور، در سال تحصیلی ۱۴۰۴ با ۶۹ هنرجو در پایه دهم و سه رشته برق صنعتی، تاسیسات مکانیکی و تعمیرکار ابزار دقیق آغاز به کار کرده است.</p>'],
            ['slug' => 'goals', 'title' => 'اهداف و رسالت',
             'body' => '<p>تربیت نیروی متخصص و کارآمد برای صنایع پتروشیمی و پالایشگاهی منطقه با تمرکز بر آموزش عملی و کارگاهی.</p>'],
            ['slug' => 'facilities', 'title' => 'امکانات هنرستان',
             'body' => '<p>کارگاه برق صنعتی، کارگاه تاسیسات مکانیکی، کارگاه ابزار دقیق، آزمایشگاه کامپیوتر و سالن همایش.</p>'],
            ['slug' => 'history', 'title' => 'تاریخچه',
             'body' => '<p>این هنرستان طی تفاهم‌نامه‌هایی با پالایشگاه گاز، پتروشیمی و اداره کل آموزش فنی و حرفه‌ای در سال ۱۴۰۴ تأسیس شد.</p>'],
            ['slug' => 'pta', 'title' => 'انجمن اولیا و مربیان',
             'body' => '<p>معرفی اعضای انجمن اولیا و مربیان هنرستان هزاره صنعت.</p>'],
        ];
        foreach ($pages as $p) { Page::updateOrCreate(['slug' => $p['slug']], $p); }

        // ── اسلایدر ──────────────────────────────────────────
        Slider::firstOrCreate(['title' => 'هنرستان هزاره صنعت'], [
            'subtitle' => 'اولین هنرستان جوار صنعت غرب کشور', 'image' => 'slider1.jpg', 'sort_order' => 1, 'is_active' => 1,
        ]);
        Slider::firstOrCreate(['title' => 'کارگاه‌های عملی'], [
            'subtitle' => 'آموزش در قلب صنعت', 'image' => 'slider2.jpg', 'sort_order' => 2, 'is_active' => 1,
        ]);
        Slider::firstOrCreate(['title' => 'همکاری با صنایع'], [
            'subtitle' => 'پالایشگاه، پتروشیمی و فنی‌حرفه‌ای', 'image' => 'slider3.jpg', 'sort_order' => 3, 'is_active' => 1,
        ]);

        // ── همایش ────────────────────────────────────────────
        // تاریخ‌ها به میلادی ذخیره می‌شوند (استاندارد دیتابیس) و در نما با Verta به شمسی نمایش داده می‌شوند
        // ۱۵ تا ۱۷ اردیبهشت ۱۴۰۳ ≈ ۴ تا ۶ می ۲۰۲۴ / مهلت ارسال: ۲۰ فروردین ۱۴۰۳ ≈ ۸ آوریل ۲۰۲۴
        // این مقادیر کاملاً قابل ویرایش از پنل مدیریت همایش هستند
        Conference::firstOrCreate(['id' => 1], [
            'title' => 'اولین همایش بین‌المللی هنرستان‌های جوار صنعت',
            'description' => 'با همکاری پتروشیمی، پالایشگاه گاز و اداره کل آموزش فنی و حرفه‌ای',
            'start_date' => '2024-05-04',
            'end_date' => '2024-05-06',
            'submission_deadline' => '2024-04-08',
            'venue' => 'اتاق همایش هنرستان هزاره صنعت',
            'is_active' => true,
        ]);

        ConferencePartner::firstOrCreate(['name' => 'پالایشگاه گاز'], ['type' => 'industry', 'sort_order' => 1]);
        ConferencePartner::firstOrCreate(['name' => 'پتروشیمی'], ['type' => 'industry', 'sort_order' => 2]);
        ConferencePartner::firstOrCreate(['name' => 'اداره کل فنی و حرفه‌ای'], ['type' => 'gov', 'sort_order' => 3]);
    }
}
