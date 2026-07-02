/* ══════════════════════════════════════════════════════════
   هنرستان هزاره صنعت — JavaScript اصلی
   ══════════════════════════════════════════════════════════ */

/* ── Persian Date ─────────────────────────────────────────── */
function toShamsi(date = new Date()) {
    const gy = date.getFullYear(), gm = date.getMonth() + 1, gd = date.getDate();
    let jy, jm, jd;
    const g_d_no = 365*gy + Math.floor((gy+3)/4) - Math.floor((gy+99)/100) + Math.floor((gy+399)/400);
    const g_d_no_prev = 365*(gy-1) + Math.floor((gy+2)/4) - Math.floor((gy+98)/100) + Math.floor((gy+398)/400);
    let gy2 = (gm > 2) ? (gy+1) : gy;
    const g_days = [0,31,59,90,120,151,181,212,243,273,304,334];
    const g_day_no = g_d_no_prev + g_days[gm-1] + ((gy2%4===0 && (gy2%100!==0 || gy2%400===0)) && gm>2 ? gd+1 : gd);
    let j_day_no = g_day_no - 79;
    const j_np = Math.floor(j_day_no / 12053); j_day_no %= 12053;
    jy = 979 + 33*j_np + 4*Math.floor(j_day_no/1461);
    j_day_no %= 1461;
    if (j_day_no >= 366) { jy += Math.floor((j_day_no-1)/365); j_day_no = (j_day_no-1)%365; }
    const j_days = [31,31,31,31,31,31,30,30,30,30,30,29];
    let i = 0;
    for (; i < 12 && j_day_no >= j_days[i]; i++) j_day_no -= j_days[i];
    jm = i + 1; jd = j_day_no + 1;
    const months = ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
    const days = ['یکشنبه','دوشنبه','سه‌شنبه','چهارشنبه','پنجشنبه','جمعه','شنبه'];
    return `${days[date.getDay()]} ${jd} ${months[jm-1]} ${jy}`;
}

function toFaNum(n) {
    return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
}

// Set Shamsi date in header
const dateEl = document.getElementById('shamsi-date');
if (dateEl) dateEl.textContent = toShamsi();

/* ── Mobile Nav ───────────────────────────────────────────── */
const navToggle = document.getElementById('nav-toggle');
const navList = document.getElementById('nav-list');

if (navToggle && navList) {
    navToggle.addEventListener('click', () => {
        navList.classList.toggle('open');
        navToggle.querySelector('i').classList.toggle('ti-menu-2');
        navToggle.querySelector('i').classList.toggle('ti-x');
    });

    // Touch: tap on has-dropdown to toggle
    document.querySelectorAll('.has-dropdown').forEach(item => {
        item.querySelector('a').addEventListener('click', function(e) {
            if (window.innerWidth < 769) {
                e.preventDefault();
                item.classList.toggle('open');
            }
        });
    });
}

/* ── Hero Slider ──────────────────────────────────────────── */
function initSlider() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    if (!slides.length) return;

    let current = 0, timer = null;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current]?.classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current]?.classList.add('active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() { timer = setInterval(next, 5000); }
    function resetAuto() { clearInterval(timer); startAuto(); }

    slides[0]?.classList.add('active');
    dots[0]?.classList.add('active');
    startAuto();

    document.querySelector('.slider-arrow.next')?.addEventListener('click', () => { next(); resetAuto(); });
    document.querySelector('.slider-arrow.prev')?.addEventListener('click', () => { prev(); resetAuto(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { goTo(i); resetAuto(); }));

    // Touch swipe
    let startX = 0;
    const sliderEl = document.querySelector('.hero-slider');
    sliderEl?.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    sliderEl?.addEventListener('touchend', e => {
        const diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 40) { diff > 0 ? prev() : next(); resetAuto(); }
    });
}

initSlider();

/* ── Announcement Tabs ────────────────────────────────────── */
function initAnnounceTabs() {
    const tabs = document.querySelectorAll('.announce-tab');
    const panels = document.querySelectorAll('.announce-panel');
    if (!tabs.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.add('d-none'));
            tab.classList.add('active');
            document.getElementById('panel-' + tab.dataset.tab)?.classList.remove('d-none');
        });
    });
}

initAnnounceTabs();

/* ── Pre-Registration Step Form ───────────────────────────── */
function initStepForm() {
    const steps = document.querySelectorAll('.form-step-panel');
    const nextBtns = document.querySelectorAll('.btn-next-step');
    const prevBtns = document.querySelectorAll('.btn-prev-step');
    const stepCircles = document.querySelectorAll('.step-circle');
    const stepLines = document.querySelectorAll('.step-line');
    if (!steps.length) return;

    let current = 0;

    function showStep(n) {
        steps.forEach((s, i) => s.classList.toggle('d-none', i !== n));
        stepCircles.forEach((c, i) => {
            c.classList.toggle('active', i === n);
            c.classList.toggle('done', i < n);
        });
        stepLines.forEach((l, i) => l.classList.toggle('done', i < n));
    }

    function validateStep1() {
        const nationalId = document.getElementById('national_id');
        if (!nationalId) return true;
        const val = nationalId.value.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
        if (!/^\d{10}$/.test(val)) {
            showFieldError(nationalId, 'کد ملی باید ۱۰ رقم و به صورت اعداد انگلیسی باشد');
            return false;
        }
        clearFieldError(nationalId);
        return true;
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (current === 0 && !validateStep1()) return;
            if (current < steps.length - 1) { current++; showStep(current); window.scrollTo(0, 0); }
        });
    });
    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (current > 0) { current--; showStep(current); window.scrollTo(0, 0); }
        });
    });

    showStep(0);
}

initStepForm();

/* ── Field Validation Helpers ─────────────────────────────── */
function showFieldError(el, msg) {
    el.classList.add('error');
    let hint = el.nextElementSibling;
    if (!hint || !hint.classList.contains('form-error')) {
        hint = document.createElement('p');
        hint.className = 'form-error';
        el.parentNode.insertBefore(hint, el.nextSibling);
    }
    hint.textContent = msg;
}
function clearFieldError(el) {
    el.classList.remove('error');
    const hint = el.nextElementSibling;
    if (hint && hint.classList.contains('form-error')) hint.remove();
}

/* ── Persian Number Prevention ────────────────────────────── */
document.querySelectorAll('input[type=tel], input[type=number], input.en-num').forEach(el => {
    el.addEventListener('input', function() {
        this.value = this.value.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    });
});

/* ── Countdown Timer ──────────────────────────────────────── */
function initCountdown() {
    const el = document.getElementById('conf-countdown');
    if (!el) return;
    const target = new Date(el.dataset.target);

    function update() {
        const now = new Date();
        const diff = target - now;
        if (diff <= 0) { el.textContent = 'همایش آغاز شده است'; return; }
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        document.getElementById('cd-days').textContent = toFaNum(String(d).padStart(2,'0'));
        document.getElementById('cd-hours').textContent = toFaNum(String(h).padStart(2,'0'));
        document.getElementById('cd-mins').textContent = toFaNum(String(m).padStart(2,'0'));
        document.getElementById('cd-secs').textContent = toFaNum(String(s).padStart(2,'0'));
    }
    update();
    setInterval(update, 1000);
}

initCountdown();

/* ── File Upload Preview ──────────────────────────────────── */
document.querySelectorAll('.form-upload input[type=file]').forEach(input => {
    input.addEventListener('change', function() {
        const label = this.closest('.form-upload').querySelector('p');
        if (this.files[0]) {
            label.textContent = `فایل انتخاب شده: ${this.files[0].name}`;
            label.style.color = 'var(--success)';
        }
    });
});

/* ── Smooth Alerts Dismiss ────────────────────────────────── */
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => { alert.style.opacity = '0'; setTimeout(() => alert.remove(), 300); }, 5000);
});

/* ── CSRF for AJAX ────────────────────────────────────────── */
const csrfToken = document.querySelector('meta[name=csrf-token]')?.content;

async function apiPost(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return res.json();
}
