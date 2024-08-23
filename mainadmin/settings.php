<?php
    session_start();
    if(isset($_SESSION['mainadmin']) && !empty($_SESSION['mainadmin'])){
        $email = $_SESSION['mainadmin'];
        require("init.php");
        $checkUser = $Functions->select("*", "`mainadmins`", "fetch", "WHERE `email` = '$email' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $settings = true;
            $background = "#f0f0f0";
            $page_title = "لوحة التحكم | الإعدادات";
            $page_name = "settings";
            require('../includes/components/header.php');
?>
    <?php include('../includes/components/admin-sidebar.php'); ?>

    <section class="content">
        <?php include('../includes/components/menus.php'); ?>
        <!-- Modal -->
        <div class="profile-tabs w-100">
            <div class="active" onclick="_change_tab(this, '#home_content')">محتوى الصفحة الرئيسية</div>
            <div onclick="_change_tab(this, '#contact_info')">بيانات التواصل</div>
        </div>
        <div class="padd position-relative" style="height:calc(100%);">
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])):
                    if(isset($_POST['web_title'])):
                        $Actions->_settings('title', $_POST['web_title']);
                    endif;
                    if(isset($_POST['web_description'])):
                        $Actions->_settings('description', $_POST['web_description']);
                    endif;
                    if(isset($_POST['facebook'])):
                        $Actions->_settings('facebook', $_POST['facebook']);
                    endif;
                    if(isset($_POST['twitter'])):
                        $Actions->_settings('twitter', $_POST['twitter']);
                    endif;
                    if(isset($_POST['phone'])):
                        $Actions->_settings('phone', $_POST['phone']);
                    endif;
                endif;
            ?>
            <div class="row h-100">
                <div class="col-md-12 info_tab" id="home_content">
                    <div class="row h-50">
                        <div class="col-md-6 mt-3">
                            <div class="card stander rounded-4 border-0 mb-3 h-100">
                                <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted fw-bold m-0">العنوان</h5>
                                </div>
                                <form method="POST" class="card-body p-2 ps-4 pe-4 mt-2">
                                    <label class="fs-7 fw-bold" for="">العنوان *</label>
                                    <textarea name="web_title" class="form-control bg-ddd" rows="7"><?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'title'")['fetch']['value']; ?></textarea>
                                    <button type="submit" name="submit" class="btn btn-default btn-bg-system w-100 fw-bold rounded-4 p-3">حفظ</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="card stander rounded-4 border-0 mb-3 h-100">
                                <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted fw-bold m-0">الوصف</h5>
                                </div>
                                <form method="POST" class="card-body p-2 ps-4 pe-4 mt-2">
                                    <label class="fs-7 fw-bold" for="">الوصف *</label>
                                    <textarea name="web_description" class="form-control bg-ddd" rows="7"><?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'description'")['fetch']['value']; ?></textarea>
                                    <button type="submit" name="submit" class="btn btn-default btn-bg-system w-100 fw-bold rounded-4 p-3">حفظ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 info_tab" id="contact_info">
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <div class="card stander rounded-4 border-0 mb-3 h-100">
                                <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted fw-bold m-0">رقم الجوال</h5>
                                </div>
                                <form method="POST" class="card-body p-2 ps-4 pe-4 mt-2">
                                    <label class="fs-7 fw-bold" for="">الرقم *</label>
                                    <input type="tel" name="phone" class="form-control mt-3 rounded-4 bg-ddd" placeholder="رقم الجوال" value="<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'phone'")['fetch']['value']; ?>" required>
                                    <div class="alert alert-primary rounded-4 w-100">الصيغة الصحيحة لرقم الجوال هي: 1066666666</div>
                                    <button type="submit" name="submit" class="btn btn-default btn-bg-system w-100 fw-bold rounded-4 p-3">حفظ</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="card stander rounded-4 border-0 mb-3 h-100">
                                <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted fw-bold m-0">Facebook Page</h5>
                                </div>
                                <form method="POST" class="card-body p-2 ps-4 pe-4 mt-2">
                                    <label class="fs-7 fw-bold" for="">الرابط *</label>
                                    <input type="url" name="facebook" class="form-control mt-3 rounded-4 bg-ddd" placeholder="رابط فيس بوك" value="<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'facebook'")['fetch']['value']; ?>" required>
                                    <button type="submit" name="submit" class="btn btn-default btn-bg-system w-100 fw-bold rounded-4 p-3">حفظ</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="card stander rounded-4 border-0 mb-3 h-100">
                                <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                                    <h5 class="text-muted fw-bold m-0">Twitter Page</h5>
                                </div>
                                <form method="POST" class="card-body p-2 ps-4 pe-4 mt-2">
                                    <label class="fs-7 fw-bold" for="">الرابط *</label>
                                    <input type="url" name="twitter" class="form-control mt-3 rounded-4 bg-ddd" placeholder="ربط تويتر" value="<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'twitter'")['fetch']['value']; ?>" required>
                                    <button type="submit" name="submit" class="btn btn-default btn-bg-system w-100 fw-bold rounded-4 p-3">حفظ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 info_tab" id="links_info">
                    <div class="card stander rounded-4 border-0 mb-3 h-100">
                        <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="text-muted fw-bold m-0">الأقسام</h5>
                        </div>
                        <div class="card-body p-2 ps-4 pe-4 mt-4">
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        function _change_tab(elem, tabid)
{
    let tabElement = document.querySelector(tabid),
        allElements = document.querySelectorAll('.info_tab');
        allElements.forEach( (tab) => {
            tab.style.display = 'none';
        });
    tabElement.style.display = 'block';
    let sibs = document.querySelectorAll('.profile-tabs div');
    sibs.forEach( (span) => {
        span.classList.remove('active');
    });
    elem.classList.add('active');
}
    </script>

<?php 
            include('../includes/components/footer.php');
        }else{
            header('location:logout.php');
            die();
        } 
    }else{
        header('location:logout.php');
        die();
    } 
?>