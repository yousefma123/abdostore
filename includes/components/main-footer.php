<?php
    if(isset($settings)){
?>
    <h1 class="d-none">بوابة الكفاءة</h1>
    <footer class="mt-3 pt-4 pb-4">
        <div class="container text-center">
            <div class="subscribe wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s">
                <a href="https://wa.me/<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'phone'")['fetch']['value']; ?>/" target="_blank" class="btn btn-default rounded-pill fs-5 scale"><span class="ms-2"> تواصل </span>  — معنا الآن</a>
                <p class="m-0 text-muted fs-7 mt-3">يمكنك مراسلتنا مباشرة عبر الواتس آب</p>
            </div>
            <div class="footer-flex d-flex justify-content-between mt-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                <div class="footer-links mt-3">
                    <a href="<?= $url ?>">الرئيسية</a>
                    <a href="#">الخصوصية</a>
                    <a href="#">شروط الاستخدام</a>
                    <a href="#">عنا</a>
                </div>
                <div class="footer-end mt-3">
                    <div>
                        <span class="copyright"><i>©</i> جميع الحقوق محفوظة</span> 
                        <a href="<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'twitter'")['fetch']['value']; ?>"><span class="fa fa-twitter"></span></a>
                        <a href="<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'facebook'")['fetch']['value']; ?>"><span class="fa fa-facebook"></span></a>
                        <a href="https://wa.me/<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'phone'")['fetch']['value']; ?>/"><span class="fa fa-whatsapp"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<?php } ?>