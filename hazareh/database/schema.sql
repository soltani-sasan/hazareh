-- ============================================================
-- هنرستان هزاره صنعت — اسکیمای کامل دیتابیس
-- ============================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS hazareh_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hazareh_db;

-- ─── کاربران ────────────────────────────────────────────────
CREATE TABLE users (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(120) NOT NULL,
    email        VARCHAR(180) UNIQUE,
    phone        VARCHAR(15),
    national_id  VARCHAR(10) UNIQUE,
    password     VARCHAR(255) NOT NULL,
    role         ENUM('admin','student','teacher','counselor','judge','conference_admin','visitor') DEFAULT 'visitor',
    avatar       VARCHAR(255),
    is_active    TINYINT(1) DEFAULT 1,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ─── هنرجویان (پروفایل کامل) ─────────────────────────────
CREATE TABLE students (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id             INT UNSIGNED UNIQUE,
    student_code        VARCHAR(20) UNIQUE,
    grade               ENUM('10','11','12') DEFAULT '10',
    field               ENUM('electrical','mechanical','instrumentation') NOT NULL,
    birth_date          DATE,
    address             TEXT,
    postal_code         VARCHAR(10),
    father_name         VARCHAR(80),
    father_phone        VARCHAR(15),
    mother_name         VARCHAR(80),
    mother_lastname     VARCHAR(80),
    mother_phone        VARCHAR(15),
    prev_school         VARCHAR(120),
    prev_district       TINYINT UNSIGNED,
    prev_principal      VARCHAR(80),
    prev_counselor      VARCHAR(80),
    last_gpa            DECIMAL(4,2),
    discipline_score    DECIMAL(4,2),
    photo_path          VARCHAR(255),
    guidance_doc_path   VARCHAR(255),
    enrollment_status   ENUM('pending','accepted','rejected','waiting') DEFAULT 'pending',
    enrollment_note     TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── پیش‌ثبت‌نام ─────────────────────────────────────────
CREATE TABLE pre_registrations (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    national_id     VARCHAR(10) NOT NULL,
    first_name      VARCHAR(80) NOT NULL,
    last_name       VARCHAR(80) NOT NULL,
    birth_date      DATE,
    home_phone      VARCHAR(15),
    mobile          VARCHAR(15) NOT NULL,
    introducer_name VARCHAR(120),
    father_name     VARCHAR(80),
    father_mobile   VARCHAR(15),
    mother_name     VARCHAR(80),
    mother_lastname VARCHAR(80),
    mother_mobile   VARCHAR(15),
    prev_school     VARCHAR(120),
    prev_district   TINYINT UNSIGNED,
    prev_principal  VARCHAR(80),
    prev_counselor  VARCHAR(80),
    last_gpa        DECIMAL(4,2),
    discipline_score DECIMAL(4,2),
    requested_field ENUM('electrical','mechanical','instrumentation') NOT NULL,
    how_known       VARCHAR(255),
    address         TEXT,
    postal_code     VARCHAR(10),
    guidance_doc    VARCHAR(255),
    status          ENUM('pending','reviewed','accepted','rejected') DEFAULT 'pending',
    admin_note      TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ─── اخبار و اطلاعیه‌ها ──────────────────────────────────
CREATE TABLE news (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id   INT UNSIGNED,
    title       VARCHAR(255) NOT NULL,
    slug        VARCHAR(255) UNIQUE NOT NULL,
    body        LONGTEXT NOT NULL,
    image       VARCHAR(255),
    category    ENUM('general','electrical','mechanical','instrumentation','extra') DEFAULT 'general',
    grade       ENUM('all','10','11','12') DEFAULT 'all',
    type        ENUM('news','notice') DEFAULT 'news',
    is_published TINYINT(1) DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── تابلو اعلانات ────────────────────────────────────────
CREATE TABLE announcements (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id   INT UNSIGNED,
    title       VARCHAR(255) NOT NULL,
    body        TEXT NOT NULL,
    section     ENUM('educational','counseling','nurturing') DEFAULT 'educational',
    priority    TINYINT DEFAULT 0,
    expires_at  DATE,
    is_active   TINYINT(1) DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── مشاوره آنلاین ────────────────────────────────────────
CREATE TABLE counseling_requests (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_type     ENUM('student','parent') NOT NULL,
    full_name       VARCHAR(120) NOT NULL,
    national_id     VARCHAR(10) NOT NULL,
    parent_name     VARCHAR(120),
    home_phone      VARCHAR(15),
    mobile          VARCHAR(15) NOT NULL,
    email           VARCHAR(180),
    reply_via       ENUM('sms','email') DEFAULT 'email',
    subject         VARCHAR(255) NOT NULL,
    is_private      TINYINT(1) DEFAULT 1,
    message         TEXT NOT NULL,
    status          ENUM('pending','answered') DEFAULT 'pending',
    responder_id    INT UNSIGNED,
    response_text   TEXT,
    responded_at    TIMESTAMP NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (responder_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── اسلایدر صفحه اصلی ────────────────────────────────────
CREATE TABLE sliders (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255),
    subtitle    VARCHAR(255),
    image       VARCHAR(255) NOT NULL,
    link        VARCHAR(255),
    sort_order  TINYINT DEFAULT 0,
    is_active   TINYINT(1) DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ─── صفحات ایستا ──────────────────────────────────────────
CREATE TABLE pages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug        VARCHAR(100) UNIQUE NOT NULL,
    title       VARCHAR(255) NOT NULL,
    body        LONGTEXT,
    updated_by  INT UNSIGNED,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── اعضای کادر ───────────────────────────────────────────
CREATE TABLE staff (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED,
    full_name   VARCHAR(120) NOT NULL,
    role_title  VARCHAR(120),
    department  ENUM('teaching','research','admin','pta') DEFAULT 'teaching',
    bio         TEXT,
    photo       VARCHAR(255),
    sort_order  TINYINT DEFAULT 0,
    is_active   TINYINT(1) DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── گزارش‌های مدیریتی ────────────────────────────────────
CREATE TABLE reports (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id   INT UNSIGNED,
    title       VARCHAR(255) NOT NULL,
    body        LONGTEXT,
    type        ENUM('action','visit','future','general') DEFAULT 'general',
    report_date DATE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── نظرات/پیشنهادات ──────────────────────────────────────
CREATE TABLE feedbacks (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(120),
    email       VARCHAR(180),
    type        ENUM('suggestion','strength','weakness','contact') DEFAULT 'suggestion',
    message     TEXT NOT NULL,
    is_read     TINYINT(1) DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ─── همایش ────────────────────────────────────────────────
CREATE TABLE conference (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(255) NOT NULL DEFAULT 'اولین همایش بین‌المللی هنرستان‌های جوار صنعت',
    description     LONGTEXT,
    start_date      DATE,
    end_date        DATE,
    submission_deadline DATE,
    venue           VARCHAR(255),
    is_active       TINYINT(1) DEFAULT 1,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE conference_registrations (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         INT UNSIGNED,
    full_name       VARCHAR(120) NOT NULL,
    national_id     VARCHAR(10),
    organization    VARCHAR(150),
    email           VARCHAR(180),
    phone           VARCHAR(15),
    participant_type ENUM('student','teacher','industry','public','other') DEFAULT 'public',
    status          ENUM('pending','confirmed','rejected') DEFAULT 'pending',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE papers (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id       INT UNSIGNED,
    title           VARCHAR(255) NOT NULL,
    abstract        TEXT NOT NULL,
    keywords        VARCHAR(255),
    track           ENUM('instrumentation','mechanical','electrical','innovation') NOT NULL,
    file_path       VARCHAR(255),
    status          ENUM('submitted','under_review','accepted','rejected','revision') DEFAULT 'submitted',
    submitted_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE paper_reviews (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paper_id        INT UNSIGNED NOT NULL,
    judge_id        INT UNSIGNED NOT NULL,
    originality     TINYINT,
    quality         TINYINT,
    relevance       TINYINT,
    presentation    TINYINT,
    total_score     DECIMAL(4,1),
    comments        TEXT,
    decision        ENUM('accept','reject','revision'),
    reviewed_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paper_id) REFERENCES papers(id) ON DELETE CASCADE,
    FOREIGN KEY (judge_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE judges (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED UNIQUE,
    name        VARCHAR(120) NOT NULL,
    title       VARCHAR(150),
    organization VARCHAR(150),
    track       ENUM('instrumentation','mechanical','electrical','innovation','all') DEFAULT 'all',
    bio         TEXT,
    photo       VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ─── شرکای همایش ──────────────────────────────────────────
CREATE TABLE conference_partners (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    logo        VARCHAR(255),
    type        ENUM('university','industry','gov') DEFAULT 'industry',
    sort_order  TINYINT DEFAULT 0
);

-- ─── داده‌های اولیه ────────────────────────────────────────
INSERT INTO users (name, email, national_id, password, role) VALUES
('مدیر سیستم', 'admin@hazareh.ir', '0000000000',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

INSERT INTO pages (slug, title, body) VALUES
('about', 'درباره هنرستان', '<p>هنرستان هزاره صنعت، اولین هنرستان جوار صنعت غرب کشور...</p>'),
('history', 'تاریخچه', '<p>این هنرستان در سال ۱۴۰۴ با ۶۹ هنرجو افتتاح شد...</p>'),
('facilities', 'امکانات', '<p>کارگاه‌های مجهز، آزمایشگاه‌های پیشرفته...</p>');

INSERT INTO conference (title, start_date, end_date, submission_deadline, venue) VALUES
('اولین همایش بین‌المللی هنرستان‌های جوار صنعت',
 '2024-05-04', '2024-05-06', '2024-04-08',
 'اتاق همایش هنرستان هزاره صنعت');

INSERT INTO sliders (title, subtitle, image, sort_order) VALUES
('هنرستان هزاره صنعت', 'اولین هنرستان جوار صنعت غرب کشور', 'slider1.jpg', 1),
('کارگاه‌های عملی', 'آموزش در قلب صنعت', 'slider2.jpg', 2),
('همکاری با صنایع', 'پالایشگاه، پتروشیمی و فنی‌حرفه‌ای', 'slider3.jpg', 3);
