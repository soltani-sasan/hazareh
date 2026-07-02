<?php
use App\Http\Controllers\Admin\AdminFeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\AdminCounselingController;
use App\Http\Controllers\Admin\AdminConferenceController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminReportController;

/*
|──────────────────────────────────────────────────────────────────────────
| Public Routes
|──────────────────────────────────────────────────────────────────────────
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Static Pages ──────────────────────────────────────────
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about/goals', [PageController::class, 'goals'])->name('about.goals');
Route::get('/about/facilities', [PageController::class, 'facilities'])->name('about.facilities');
Route::get('/pta', [PageController::class, 'pta'])->name('pta');

// ── Staff Pages ───────────────────────────────────────────
Route::get('/staff/teaching', [PageController::class, 'staffTeaching'])->name('staff.teaching');
Route::get('/staff/executive', [PageController::class, 'staffExecutive'])->name('staff.executive');

// ── News ──────────────────────────────────────────────────
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news/field/{field}', [NewsController::class, 'byField'])->name('news.field');
Route::get('/news/grade/{grade}', [NewsController::class, 'byGrade'])->name('news.grade');

// ── Announcements ─────────────────────────────────────────
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

// ── Fields ────────────────────────────────────────────────
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show')
    ->where('field', 'electrical|mechanical|instrumentation');

// ── Registration ──────────────────────────────────────────
Route::get('/pre-registration', [RegistrationController::class, 'form'])->name('pre-registration.form');
Route::post('/pre-register', [RegistrationController::class, 'store'])->name('pre-register.store');
Route::get('/pre-register/success', [RegistrationController::class, 'success'])->name('pre-register.success');

// ── Top Students & Extra Activities ──────────────────────
Route::get('/top-students', [PageController::class, 'topStudents'])->name('top-students');
Route::get('/extra-activities', [PageController::class, 'extraActivities'])->name('extra-activities');

// ── Counseling ────────────────────────────────────────────
Route::get('/counseling', [CounselingController::class, 'form'])->name('counseling.form');
Route::post('/counseling', [CounselingController::class, 'store'])->name('counseling.store');
Route::get('/counseling/track', [CounselingController::class, 'trackForm'])->name('counseling.track');
Route::post('/counseling/track', [CounselingController::class, 'track'])->name('counseling.track.search');
Route::get('/counseling/success', [CounselingController::class, 'success'])->name('counseling.success');

// ── Contact & Feedback ────────────────────────────────────
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/feedback', [ContactController::class, 'feedback'])->name('feedback');
Route::post('/feedback', [ContactController::class, 'storeFeedback'])->name('feedback.store');

// ── App Download ──────────────────────────────────────────
Route::get('/app', [PageController::class, 'appDownload'])->name('app.download');

// ── Conference ────────────────────────────────────────────
Route::prefix('conference')->name('conference.')->group(function () {
    Route::get('/', [ConferenceController::class, 'index'])->name('index');
    Route::get('/schedule', [ConferenceController::class, 'schedule'])->name('schedule');
    Route::get('/results', [ConferenceController::class, 'results'])->name('results');

    Route::get('/register', [ConferenceController::class, 'registerForm'])->name('register');
    Route::post('/register', [ConferenceController::class, 'register'])->name('register.store');

    Route::middleware(['auth'])->group(function () {
        Route::get('/submit', [ConferenceController::class, 'submitForm'])->name('submit');
        Route::post('/submit', [ConferenceController::class, 'submitPaper'])->name('submit.store');
        Route::get('/my-paper', [ConferenceController::class, 'myPaper'])->name('my-paper');
    });

    // Judge panel
    Route::middleware(['auth', 'role:judge,conference_admin,admin'])->group(function () {
        Route::get('/judge', [ConferenceController::class, 'judgePanel'])->name('judge');
        Route::get('/judge/paper/{id}', [ConferenceController::class, 'reviewForm'])->name('judge.review');
        Route::post('/judge/paper/{id}', [ConferenceController::class, 'submitReview'])->name('judge.review.store');
    });
});

/*
|──────────────────────────────────────────────────────────────────────────
| Auth Routes
|──────────────────────────────────────────────────────────────────────────
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register-user', [AuthController::class, 'registerForm'])->name('register.form');
    Route::post('/register-user', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.forgot');
Route::post('/forgot-password', [AuthController::class, 'sendReset'])->name('password.email');

/*
|──────────────────────────────────────────────────────────────────────────
| Student / User Panel Routes
|──────────────────────────────────────────────────────────────────────────
*/
Route::middleware(['auth'])->prefix('panel')->name('panel.')->group(function () {
    Route::get('/', [PanelController::class, 'index'])->name('index');
    Route::get('/profile', [PanelController::class, 'profile'])->name('profile');
    Route::post('/profile', [PanelController::class, 'updateProfile'])->name('profile.update');
    Route::get('/registration-status', [PanelController::class, 'registrationStatus'])->name('reg-status');
    Route::get('/counseling', [PanelController::class, 'myCounseling'])->name('counseling');
    Route::get('/news', [PanelController::class, 'myNews'])->name('news');
});

/*
|──────────────────────────────────────────────────────────────────────────
| Admin Routes
|──────────────────────────────────────────────────────────────────────────
*/
Route::middleware(['auth', 'role:admin,conference_admin,teacher,counselor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // تماس با ما و نظرات
    Route::get('feedback',         [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('feedback/{id}',    [AdminFeedbackController::class, 'show'])->name('feedback.show');
    Route::delete('feedback/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');
    // News & Announcements
    Route::resource('news', AdminNewsController::class);
    Route::post('news/{id}/publish', [AdminNewsController::class, 'publish'])->name('news.publish');
    Route::resource('announcements', AdminAnnouncementController::class);

    // Registrations
    Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{id}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::post('registrations/{id}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.status');
    Route::get('registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');

    // Counseling (admin + counselor only)
    Route::middleware('role:admin,counselor')->group(function () {
        Route::get('counseling', [AdminCounselingController::class, 'index'])->name('counseling.index');
        Route::get('counseling/{id}', [AdminCounselingController::class, 'show'])->name('counseling.show');
        Route::post('counseling/{id}/reply', [AdminCounselingController::class, 'reply'])->name('counseling.reply');
    });

    // Staff management (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('staff', AdminStaffController::class);
        Route::resource('sliders', AdminSliderController::class);
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::post('reports', [AdminReportController::class, 'store'])->name('reports.store');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::post('users/{id}/role', [AdminController::class, 'updateRole'])->name('users.role');
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('settings', [AdminController::class, 'saveSettings'])->name('settings.save');
    });

    // Conference Management
    Route::middleware('role:admin,conference_admin')->group(function () {
        Route::get('conference', [AdminConferenceController::class, 'index'])->name('conference.index');
        Route::post('conference', [AdminConferenceController::class, 'update'])->name('conference.update');
        Route::get('conference/papers', [AdminConferenceController::class, 'papers'])->name('conference.papers');
        Route::post('conference/papers/{id}/assign', [AdminConferenceController::class, 'assignJudge'])->name('conference.assign');
        Route::get('conference/registrations', [AdminConferenceController::class, 'registrations'])->name('conference.registrations');
        Route::get('conference/results', [AdminConferenceController::class, 'results'])->name('conference.results');
    });
});
