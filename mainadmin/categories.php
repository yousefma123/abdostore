<?php
    session_start();
    if(isset($_SESSION['mainadmin']) && !empty($_SESSION['mainadmin'])){
        $email = $_SESSION['mainadmin'];
        require("init.php");
        $checkUser = $Functions->select("*", "`mainadmins`", "fetch", "WHERE `email` = '$email' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $settings = true;
            $background = "#f0f0f0";
            $page_title = "لوحة التحكم | الأقسام";
            $page_name = "categories";
            require('../includes/components/header.php');
?>
    <?php include('../includes/components/admin-sidebar.php'); ?>

    <section class="content">
        <?php include('../includes/components/menus.php'); ?>
        <!-- Modal -->
        <div class="padd position-relative">
            <div class="row h-100">
                <div class="col-md-12">
                    <div class="card stander rounded-4 border-0 mb-3 h-100">
                        <div class="card-header p-3 ps-4 pe-4 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="text-muted fw-bold m-0">الأقسام</h5>
                            <button type="button" class="btn btn-primary btn-modal" data-bs-toggle="modal" data-bs-target="#addCategory">
                                إضافة قسم
                                <span class="fa fa-plus me-1"></span>
                            </button>
                        </div>
                        <div class="card-body p-2 ps-4 pe-4 mt-4">
                            <?php
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewCategory'])):
                                    $Actions->_addNewCategories($_POST['name_ar'], $_POST['name_en']);
                                endif;
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCategory'])):
                                    $Actions->_editCategory($_POST['cat_id'], $_POST['name_ar'], $_POST['name_en'], $_POST['status']);
                                endif;
                                if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'):
                                    $Actions->_removeCategory($_GET['catid']);
                                endif;
                                $getCategories = $Functions->select("*", "`categories`", "fetchAll");
                                if($getCategories['rowCount'] > 0){
                            ?>
                                <table class="table table-striped text-center tb-show">
                                    <thead>
                                        <tr>
                                        <th scope="col">الرقم</th>
                                        <th scope="col">اسم القسم عربي</th>
                                        <th scope="col">اسم القسم انجليزي</th>
                                        <th scope="col">حالة القسم</th>
                                        <th scope="col">الترتيب</th>
                                        <th scope="col">التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($getCategories['fetchAll'] as $category){
                                        ?>
                                            <div class="modal fade" id="editCategory_<?= $category['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex justify-content-between">
                                                            <h6 class="modal-title" id="exampleModalLabel">إضافة قسم جديد</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST">
                                                            <div class="modal-body m-0">
                                                                <div class="row">
                                                                    <input type="hidden" name="cat_id" value="<?= $category['id'] ?>">
                                                                    <div class="col-md-12">
                                                                        <input type="text" name="name_ar" class="form-control" placeholder="الاسم بالعربي" value="<?= $category['name_ar'] ?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <input type="text" name="name_en" class="form-control" placeholder="الاسم بالانجليزي" value="<?= $category['name_en'] ?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <select name="status" class="form-control">
                                                                            <option value="">حالة الظهور</option>
                                                                            <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ; ?>>إخفاء</option>
                                                                            <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ; ?>>إظهار</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="submit" name="editCategory" class="btn btn-dark rounded-4 btn-modal">تعديل</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <tr>
                                                <th scope="row"><?= $category['id'] ?></th>
                                                <td><?= $category['name_ar'] ?></td>
                                                <td><?= $category['name_en'] ?></td>
                                                <td class="<?= $category['status'] == 1 ? 'activePoint' : 'notActivePoint' ; ?>"><?= $category['status'] == 1 ? 'مفعل' : 'معطل' ; ?></td>
                                                <td><input type="number" onblur="_changePlace(this)" data-id="<?= $category['id'] ?>" class="form-control bg-ddd m-0" value="<?= $category['arrangement'] ?>" placeholder="المكان"></td>
                                                <td>
                                                    <a href="?action=delete&catid=<?= $category['id'] ?>" class="btn btn-danger p-1 ps-2 pe-2 ms-2 rounded-3 border-0">
                                                        <span class="fa fa-trash"></span>
                                                    </a>
                                                    <button class="btn btn-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0" data-bs-toggle="modal" data-bs-target="#editCategory_<?= $category['id'] ?>">
                                                        <span class="fa fa-edit"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php 
                                }else{
                                    echo "<div class='alert alert-warning rounded-4'>لا يوجد أقسام مضافة مسبقا</div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reject Service Modal -->
        <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h6 class="modal-title" id="exampleModalLabel">إضافة قسم جديد</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body m-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="name_ar" class="form-control" placeholder="الاسم بالعربي">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" class="form-control" placeholder="الاسم بالانجليزي">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" name="addNewCategory" class="btn btn-dark rounded-4 btn-modal">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
        function _changePlace(elem)
        {
            const data = {
                category_id : elem.getAttribute('data-id'),
                value       : elem.value.trim()
            };
            if(!isNaN(data.value)){
                const ajax = new XMLHttpRequest();
                ajax.onload = function (){
                    if(this.status == 200){
                        elem.style.borderColor = 'green';
                    }
                }
                ajax.open('POST', '../classes/Actions.php');
                ajax.setRequestHeader("content-type","application/x-www-form-urlencoded");
                ajax.send("changePlaceData="+JSON.stringify(data));
            }
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