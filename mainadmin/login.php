<?php
    session_start();
    ob_start();
    if(isset($_SESSION['mainadmin'])){
        header("location:home");
        die();
    }
    $settings = true;
    $page_title = "Zara Store | login";
    include("../includes/components/header.php");
    if(!isset($_SESSION['token']) || empty($_SESSION['token'])){
        require ('../classes/Functions.php');
        $Functions = new Functions();
        $_SESSION['token'] = $Functions->_createToken();
    }
?>

    <div class="container">
        <div class="login-page h-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col-md-12">
                    <div class="login w-100 p-3 p-5 text-center rounded-4">
                        <h2 class="text-center mb-5 fw-bold">تسجيل الدخول</h2>
                        <?php
                            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
                                require('../classes/Users.php');
                                $Users = new Users();
                                $Users->_loginMainAdmins($_POST['email'], $_POST['password'], $_POST['token']);
                            }
                        ?>
                        <form method="POST">
                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                            <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
                            <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                            <button name="login" class="btn btn-default w-100 rounded-4 btn-system shadow-sm">تسجيل</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include("../includes/components/footer.php"); ob_end_flush(); ?>
