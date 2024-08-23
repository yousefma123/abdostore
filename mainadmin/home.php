<?php
    session_start();
    if(isset($_SESSION['mainadmin']) && !empty($_SESSION['mainadmin'])){
        $email = $_SESSION['mainadmin'];
        require("init.php");
        $checkUser = $Functions->select("*", "`mainadmins`", "fetch", "WHERE `email` = '$email' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $settings = true;
            $page_title = "لوحة التحكم | الرئيسية";
            $background = "#f0f0f0";
            $page_name = "dashboard";
            require('../includes/components/header.php');
?>

    <?php include('../includes/components/admin-sidebar.php'); ?>

    <section class="content">
        <?php include('../includes/components/menus.php'); ?>
        <div class="padd position-relative">
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-4 rounded-4 border-0 mb-3">
                        <h3 class="fw-bold mb-2">عدد الأقسام</h3>
                        <div class="h5 fw-bold"><?= $Functions->select("`id`", "`categories`", "fetchAll")['rowCount']; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="card p-4 rounded-4 border-0 mb-3">
                        <h3 class="fw-bold mb-2">عدد المنتجات</h3>
                        <div class="h5 fw-bold"><?= $Functions->select("`id`", "`products`", "fetchAll")['rowCount']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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