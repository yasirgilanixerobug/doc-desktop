<footer class="footer-bg">
    <div class="container">
        <div class="row footer-margins">
            <div class="col-md-6 footer-margins">
                <div class="f-top-content">
                    <img style="height: 100px; width: 100px"  src="{{ asset(config('app.logo_white')) }}" alt="">
                    <div class="footer-icon">
                        <a target="_blank" href="https://www.facebook.com/fivedocsOfficial"><i class="fa-brands fa-facebook"></i></a>
                        <a target="_blank" href="https://www.instagram.com/fivedocsofficial/"><i class="fa-brands fa-instagram"></i></a>
                        <a target="_blank" href="https://www.linkedin.com/company/sssoftech/"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                    <!--<div class="privacy-policy">-->
                    <!--    <a href="#">PRIVACY POLICY</a>-->
                    <!--    <a href="#">COOKIE POLICY</a>-->
                    <!--    <a href="#">TERMS</a>-->
                    <!--</div>-->
                </div>
            </div>
            <div class="col-md-2 footer-margins media-set-f-links f-top-links">
                <div class="privacy-policy">
                    <a href="{{ route('privacyPolicy') }}" target="_blank">PRIVACY POLICY</a>
                    <!-- <a href="#">COOKIE POLICY</a> -->
                    <a href="{{ route('termsAndConditions') }}" target="_blank">TERMS CONDITIONS</a>
                </div>
            </div>
            <!--<div class="col-md-2 footer-margins media-set-f-links f-top-links">-->
            <!--    <div class="privacy-policy">-->
            <!--        <a href="#">PRICING</a>-->
            <!--        <a href="#">SPORT</a>-->
            <!--        <a href="#">CHAT</a>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-md-2 footer-margins media-set-f-links f-top-links">-->
            <!--    <div class="privacy-policy">-->
            <!--        <a href="#">BLOG</a>-->
            <!--        <a href="#">CAREERS</a>-->
            <!--        <a href="#">GDPR</a>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <p>©Copyright {{ date('Y') }} All Rights Reserved.</p> Powered By: <a target="_blank" href="https://fivedocs.com/"><b style="color: white">Five Docs</b></a>
                </div>
            </div>
        </div>
    </div>
</footer>
