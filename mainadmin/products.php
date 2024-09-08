<?php
    session_start();
    if(isset($_SESSION['mainadmin']) && !empty($_SESSION['mainadmin'])){
        $email = $_SESSION['mainadmin'];
        require("init.php");
        $checkUser = $Functions->select("*", "`mainadmins`", "fetch", "WHERE `email` = '$email' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $settings = true;
            $background = "#f0f0f0";
            $page_title = "لوحة التحكم | المنتجات";
            $page_name = "products";
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
                            <h5 class="text-muted fw-bold m-0">المنتجات</h5>
                            <button type="button" class="btn btn-primary btn-modal" data-bs-toggle="modal" data-bs-target="#addNewItem">
                                إضافة منتج
                                <span class="fa fa-plus me-1"></span>
                            </button>
                        </div>
                        <div class="card-body p-2 ps-4 pe-4 mt-4">
                            <?php
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addNewItem'])):
                                    $item_data = [
                                        "category_id"       => $_POST['category_id'],
                                        "name"              => $_POST['name'],
                                        "model"             => $_POST['model'],
                                        "details_keys"      => $_POST['details_keys'],
                                        "details_values"    => $_POST['details_values'],
                                        "images"            => $_FILES['images'],
                                        "price"             => $_POST['price']
                                    ];
                                    $Actions->_addNewItems($item_data);
                                endif;
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCategory'])):
                                    $Actions->_editCategory($_POST['cat_id'], $_POST['name_ar'], $_POST['name_en']);
                                endif;
                                if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'):
                                    $Actions->_removeProduct($_GET['pid']);
                                endif;
                                $getProducts = $Functions->_getJoinData(
                                    "`products`.*, `products`.date AS productDate, `categories`.name_ar",
                                    "`products`",
                                    "INNER JOIN `categories` ON `categories`.id = `products`.category_id",
                                    "fetchAll"
                                );
                                if($getProducts['rowCount'] > 0){
                            ?>
                                <table class="table table-striped text-center tb-show">
                                    <thead>
                                        <tr>
                                            <th scope="col">الرقم</th>
                                            <th scope="col">اسم المنتج</th>
                                            <th scope="col">اسم القسم</th>
                                            <th scope="col">رقم الموديل</th>
                                            <th scope="col">صور المنتج</th>
                                            <th scope="col">تاريخ الإضافة</th>
                                            <th scope="col">التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($getProducts['fetchAll'] as $item){
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $item['id'] ?></th>
                                                <td><?= $item['name'] ?></td>
                                                <td><?= $item['name_ar'] ?></td>
                                                <td><?= $item['model'] ?></td>
                                                <td>
                                                    <?php 
                                                        $images = explode(',', $item['images']);
                                                        foreach($images as $img){
                                                    ?>
                                                        <img src="<?= $url ?>/includes/uploads/products/images/<?= trim($img) ?>" alt="img">
                                                    <?php } ?>
                                                </td>
                                                <td><?= $item['productDate'] ?></td>
                                                <td>
                                                    <button class="btn btn-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0" data-bs-toggle="modal" data-bs-target="#editCategory_<?= $category['id'] ?>">
                                                        <span class="fa fa-edit"></span>
                                                    </button>
                                                    <a href="<?= $url ?>/products?pn=<?= str_replace([' ',',','.','@','،'], '-', $item['name']) ?>&pid=<?= $item['id'] ?>" target="_blanck" class="btn btn-warning p-1 ps-2 pe-2 ms-2 rounded-3 border-0">
                                                        <span class="fa fa-eye"></span>
                                                    </a>
                                                    <a href="?action=delete&pid=<?= $item['id'] ?>" class="btn btn-danger p-1 ps-2 pe-2 ms-2 rounded-3 border-0">
                                                        <span class="fa fa-trash"></span>
                                                    </a>
                                                    <!-- <a href="?action=avilabel_status=<?= $item['id'] ?>" class="btn btn-success p-1 ps-2 pe-2 ms-2 rounded-3 border-0">
                                                        <span class="fa fa-eye"></span>
                                                    </a> -->
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php 
                                }else{
                                    echo "<div class='alert alert-warning rounded-4'>لا يوجد منتجات مضافة مسبقا</div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add Item Modal -->
        <div class="modal fade" id="addNewItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h6 class="modal-title" id="exampleModalLabel">إضافة منتج جديد</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-body m-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="name" class="form-control" placeholder="اسم المنتج" required>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" name="category_id">
                                        <option value="">اختر القسم</option>
                                        <?php
                                            $getCats = $Functions->select("`id`, `name_ar`", "`categories`", "fetchAll");
                                            foreach($getCats['fetchAll'] as $category){
                                        ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name_ar'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-12">
                                    <input type="text" name="model" class="form-control" placeholder="رقم الموديل">
                                </div>
                                <div class="col-md-12">
                                    <label class="fs-7 fw-bold" for="">مواصفات المنتج  *</label>
                                    <div class="row align-items-center">
                                        <div class="col-md-11">
                                            <div class="row" id="addNewInput">
                                                <div class="col-md-6">
                                                    <input type="text" name="details_keys[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم المواصفة" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="details_values[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="القيمة">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary rounded-4 w-100 repeated-inputs shadow-sm" onclick="_add_hosting_input()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 mt-2 label_uploader">
                                    <div class="fs-7 fw-bold mb-3">رفع صور المنتج *</div>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <label class="fs-7 fw-bold" for="upload_file_1" id="lbl-upload-1" style="height:130px;">رفع صور المنتج</label>
                                            <input multiple onchange="_upload_files(this, '', '[png, jpg, jpeg, webp]', '#lbl-upload-1')" accept="image/png, image/jpg, image/jpeg, image/webp" type="file" id="upload_file_1" name="images[]" class="form-control mt-3 rounded-4 bg-ddd" style="display:none;">
                                        </div>
                                        <p class="fs-7 text-muted fw-bold">ملاحظة: برجاء رفع صورة مساحتها (300px * 200px) - علما أن الإمتدادات المسموح بها هم png - jpg - jpeg - webp</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="number" name="price" class="form-control" placeholder="سعر المنتج" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" name="addNewItem" class="btn btn-dark rounded-4 btn-modal">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
        function _add_hosting_input()
        {
            const addNewInput   = document.getElementById('addNewInput');
            let _newCol         = document.createElement('div');
            let _newCol2        = document.createElement('div');
            _newCol.className   = 'col-md-6';
            _newCol2.className  = 'col-md-6';
            _newCol.innerHTML   = `<input type="text" name="details_keys[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم المواصفة">`;
            _newCol2.innerHTML  = `<input type="text" name="details_values[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="القيمة">`;
            addNewInput.appendChild(_newCol);
            addNewInput.appendChild(_newCol2);
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