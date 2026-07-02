<footer class="site-footer">

    <div class="footer-top">

        <div class="container">

            <div class="footer-grid">

                <div>

                    <h3 class="footer-title">
                        هنرستان هزاره صنعت
                    </h3>

                    <p>
                        اولین هنرستان جوار صنعت غرب کشور
                    </p>

                    <p>
                        با همکاری پالایشگاه گاز، پتروشیمی و اداره کل آموزش فنی و حرفه‌ای
                    </p>

                    <br>

                    <p>
                        <i class="ti ti-map-pin"></i>
                        آدرس هنرستان هزاره صنعت
                    </p>

                    <p>
                        <i class="ti ti-phone"></i>
                        شماره تماس هنرستان
                    </p>

                    <p>
                        <i class="ti ti-mail"></i>
                        info@hazareh.ir
                    </p>

                </div>

                <div>

                    <h3 class="footer-title">
                        دسترسی سریع
                    </h3>

                    <ul class="footer-links">

                        <li><a href="{{ route('home') }}">صفحه اصلی</a></li>

                        <li><a href="{{ route('about') }}">درباره هنرستان</a></li>

                        <li><a href="{{ route('fields.index') }}">رشته‌ها</a></li>

                        <li><a href="{{ route('news.index') }}">اخبار</a></li>

                        <li><a href="{{ route('conference.index') }}">همایش</a></li>

                        <li><a href="{{ route('contact') }}">تماس با ما</a></li>

                    </ul>

                </div>

                <div>

                    <h3 class="footer-title">
                        موقعیت هنرستان
                    </h3>

                    <div class="footer-map">

                        <iframe
                        src="https://maps.google.com/maps?q=https://maps.app.goo.gl/GWGse8uB8n5Ugs1NA&output=embed"
                        loading="lazy"
                        allowfullscreen>
                        </iframe>

                    </div>

                    <br>

                    <a class="btn btn-accent"
                       target="_blank"
                       href="https://maps.app.goo.gl/GWGse8uB8n5Ugs1NA">

                        مشاهده در Google Maps

                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="footer-bottom">

        © {{ date('Y') }}

        هنرستان هزاره صنعت

        <br>

        طراحی و توسعه با ساسان سلطانی مدیر هنرستان برای صنعت ایران

    </div>

</footer>