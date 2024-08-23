<?php 

    class Actions {

        public $conn, $Functions;

        public function __construct()
        {
            require_once ('Connection.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            require_once('Functions.php');
            $this->Functions = new Functions();
        }

        public function _addNewCategories($name_ar, $name_en)
        {
            $name_ar = trim(strip_tags($name_ar));
            $name_en = trim(strip_tags($name_en));
            if(isset($name_ar) && !empty($name_ar) && isset($name_ar) && !empty($name_ar))
            {   
                $insert = $this->conn->prepare("INSERT INTO `categories` (`name_ar`, `name_en`) VALUES(?, ?)");
                $insert->execute([$name_ar, $name_en]);
                if($insert->rowCount() > 0){
                    echo "<div class='alert alert-success rounded-4 shadow-sm'>تم إضافة القسم بنجاح</div>";
                }
            }
        }

        public function _addNewItems($data)
        {
            $errors = [];

            $name   = trim(strip_tags($data['name']));
            $price  = trim(strip_tags($data['price']));
            $model  = trim(strip_tags($data['model']));

            if(empty($data['category_id']) || !is_numeric($data['category_id'])){
                $errors[] .= "Error in category id!";
            }else{
                $catid = trim(strip_tags($data['category_id']));
                if($this->Functions->select("`id`", "`categories`", "fetch", "WHERE `id` = $catid")['rowCount'] != 1){
                    $errors[] .= "Error in category !";
                }
            }

            if(!isset($name) || empty($name)){
                $errors[] .= "Error in item name";
            }

            if(!isset($price) || empty($price)){
                $errors[] .= "Error in item price";
            }

            if(!isset($model) || empty($model)){
                $errors[] .= "Error in item model";
            }

            $details_keys   = [];
            $details_values = [];
            if(isset($data['details_keys'][0]) && !empty($data['details_keys'][0])){
                foreach($data['details_keys'] as $key => $info_key){
                    $details_keys[]     .= $data['details_keys'][$key];
                    $details_values[]   .= $data['details_values'][$key];
                }
            }else{
                $errors[] .= "Error in item details";
            }

            if(isset($data['images']) && count($data['images']['tmp_name']) >= 1 && count($data['images']['tmp_name']) <= 4){

                foreach($data['images']['tmp_name'] as $key => $image){
                    $array_img = [
                        "name"      => $data['images']['name'][$key],
                        "size"      => $data['images']['size'][$key],
                        "tmp_name"  => $data['images']['tmp_name'][$key]
                    ];
                    $upload_image = $this->Functions->_upload_file(
                        $array_img,
                        'null',
                        5000000,
                        ['png', 'jpg', 'jpeg', 'webp'], true
                    );
                    if($upload_image['type'] == "error"){
                        $errors[] .= $upload_image['message'];
                    }
                }

            }else{
                $errors[] .= "Error in item images count !";
            }

            if(empty($errors)){

                $new_images_names = [];

                foreach($data['images']['tmp_name'] as $key => $image){
                    $array_img = [
                        "name"      => $data['images']['name'][$key],
                        "size"      => $data['images']['size'][$key],
                        "tmp_name"  => $data['images']['tmp_name'][$key]
                    ];
                    $upload_image = $this->Functions->_upload_file(
                        $array_img,
                        '/includes/uploads/products/images/',
                        5000000,
                        [],
                        false, false
                    );
                    if($upload_image['type'] == 'success') $new_images_names[] .= $upload_image['file_name'];
                }

                $insert = $this->conn->prepare("INSERT INTO `products` (`category_id`, `name`, `model`, `details_keys`, `details_values`, `images`, `price`)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insert->execute([
                    $data['category_id'],
                    $name,
                    $model,
                    implode(',', $details_keys),
                    implode(',', $details_values),
                    implode(',',$new_images_names),
                    $price
                ]);
                if($insert->rowCount() > 0){
                    echo '<div class="alert alert-success rounded-4">تم إضافة المنتج بنجاح.</div>';
                }
            }else{
                $show_errors = '';
                foreach($errors as $err){
                    $show_errors .= "<div>".$err."</div>"; 
                }
                echo '<div class="alert alert-danger rounded-4"><div>'.$show_errors.'</div></div>';
            }

        }

        public function _editCategory($id, $category_name_ar, $category_name_en, $status)
        {
            if(isset($id) && is_numeric($id) && isset($category_name_ar) && !empty($category_name_ar) 
            && isset($category_name_en) && !empty($category_name_en) && isset($status) && ($status == 1 || $status == 0))
            {
                $category_name_ar = trim(strip_tags($category_name_ar));
                $category_name_an = trim(strip_tags($category_name_en)); 
                
                $update = $this->conn->prepare("UPDATE `categories` SET `name_ar` = ?, `name_en` = ?, `status` = ? WHERE `id` = ?");
                $update->execute([$category_name_ar, $category_name_en, $status, $id]);
                if($update->rowCount() > 0){
                    echo "<div class='alert alert-success rounded-4'>تم تعديل القسم بنجاح</div>";
                }
            }else{
                echo "<div class='alert alert-danger rounded-4'>برجاء إدخال جميع الحقول المطلوبة للتعديل</div>";
            }
        }

        public function _removeCategory(Int $id)
        {
            if(is_numeric($id)){
                $delete = $this->conn->prepare("DELETE FROM `categories` WHERE `id` = ?");
                $delete->execute([trim(strip_tags($id))]);
                if($delete->rowCount() > 0){
                    echo "<div class='alert alert-success rounded-4'>تم حذف القسم بنجاح</div>";
                }
            }
        }

        public function _removeProduct(Int $id)
        {
            if(is_numeric($id)){
                $delete = $this->conn->prepare("DELETE FROM `products` WHERE `id` = ?");
                $delete->execute([trim(strip_tags($id))]);
                if($delete->rowCount() > 0){
                    echo "<div class='alert alert-success rounded-4'>تم حذف المنتج بنجاح</div>";
                }
            }
        }

        public function _settings($key, $value)
        {
            $value = trim(strip_tags($value));
            if(isset($key) && !empty($key) && isset($value) && !empty($value)){
                $update = $this->conn->prepare("UPDATE `settings` SET `value` = ? WHERE `key` = ?");
                $update->execute([$value, $key]);
                if($update->rowCount() > 0){
                    echo "<div class='alert mt-2 alert-success rounded-4'>تم تحديث بيانات الموقع بنجاح</div>";
                }
            }
        }
        public function _changePlaces($data)
        {
            $data = json_decode($data, true);
            $update = $this->conn->prepare("UPDATE `categories` SET `arrangement` = ? WHERE `id` = ?");
            $update->execute([$data['value'], $data['category_id']]);
            if($update->rowCount() > 0){
                echo 'true';
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changePlaceData'])):
        $Actions = new Actions();
        $Actions->_changePlaces($_POST['changePlaceData']);
    endif;