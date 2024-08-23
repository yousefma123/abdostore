<?php 

    class Users {

        public $conn, $Functions;
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _loginMainAdmins($email, $password, $token)
        {
            if(isset($token) && $token === $_SESSION['token']){
                if(isset($email) && !empty($email) && isset($password) && !empty($password)){
                    $email   = trim(strip_tags($email));
                    $password= SHA1($password);
                    $stmt = $this->conn->prepare("SELECT * FROM `mainadmins` WHERE `email` = ? && `password` = ?");
                    $stmt->execute([$email, $password]);
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch();
                        $_SESSION['mainadmin'] = $fetch_data['email'];
                        header("location:home");
                        die();
                    }else{
                        echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger text-center w-100 rounded-4'>برجاء إدخال جميع الحقول المطلوبة بالصيغة الصحيحة</div>";
                }
            }
        }

        // public function _loginMainAdmins($email, $password, $token)
        // {
        //     if(isset($token) && $token === $_SESSION['token'] && !isset($_SESSION['mainadmin'])){
        //         if(isset($email) && isset($password) && !empty($password)){
        //             $stmt = $this->conn->prepare("SELECT * FROM `mainadmins` WHERE `email` = :email && `status` = 1");
        //             $stmt->bindParam(":email", $email);
        //             $stmt->execute();
        //             if($stmt->rowCount() == 1){
        //                 $fetch_data = $stmt->fetch();
        //                 if(password_verify($password, $fetch_data['password'])){
        //                     $_SESSION['mainadmin'] = $fetch_data['email'];
        //                     header("location:home");
        //                     exit();
        //                 }else{
        //                     echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
        //                 }
        //             }else{
        //                 echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
        //             }
        //         }else{
        //             echo "<div class='alert alert-danger text-center w-100 rounded-4'>برجاء إدخال جميع الحقول المطلوبة بالصيغة الصحيحة</div>";
        //         }
        //     }
        // }

        public function _activeAccount($code, $email)
        {
            $code   = trim(strip_tags($code));
            $email  = trim(strip_tags($email));
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `email` = ? && `verify_code` = ? && `status` = ?");
                $stmt->execute([$email, $code, 0]);
                if($stmt->rowCount() == 1){
                    $update = $this->conn->prepare("UPDATE `users` SET `status` = ? WHERE `email` = ?");
                    $update->execute([1, $email]);
                    if($update->rowCount() == 1){
                        echo "<div class='mb-4 alert alert-success text-center w-100 rounded-4'>تم تفعيل حسابك بنجاح <br> برجاء تسجيل الدخول</div>";
                    }
                }
            }
        }

    }