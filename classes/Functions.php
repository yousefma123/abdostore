<?php

    class Functions {

        public $conn;

        public function __construct()
        {
            require_once ('Connection.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
        }

        public function _createToken()
        {
            $createBytes    = openssl_random_pseudo_bytes(16);
            $convertBytes   = bin2hex($createBytes);
            return $convertBytes;
        }

        public function select($what, $table, $process, $where = NULL, $limit = NULL, $orderBy = "ORDER BY id DESC")
        {
            $stmt = $this->conn->prepare("SELECT $what FROM $table $where $orderBy $limit");
            $stmt->execute();
            switch ($process){
              case "fetch":
                return [
                  "rowCount"  => $stmt->rowCount(),
                  "fetch"     => $stmt->fetch(),
                ];
                break;
              case "fetchAll":
                return [
                  "rowCount" => $stmt->rowCount(),
                  "fetchAll" => $stmt->fetchAll(),
                ];
                break;
              }
        }

        public function _upload_file(Array $file_array, String $src, Int $size_allowd, Array $types_allowed, $check_before = false, $check_ext = true) 
        :Array 
        {   
            $status = [];

            $file_name  = strtolower($file_array['name']);
            $cut_file   = explode('.', $file_name);
            $file_type  = end($cut_file);
            if($check_ext == true){
            if(in_array($file_type, $types_allowed))
                {
                    if($file_array['size'] > $size_allowd)
                    {
                        $status['type']     = "error";
                        $status['message']  = "حجم الملف كبير للغاية";
                    }
                }else{
                    $status['type']     = "error";
                    $status['message']  = "برجاء رفع ملف مطابق للأنواع المسموح بها";
                }
            }

            if(empty($status)){
                if($check_before == false){
                    $random_file_name = bin2hex(openssl_random_pseudo_bytes(8)).time().'.'.$file_type;
                    if(move_uploaded_file($file_array['tmp_name'], dirname(__DIR__).$src.$random_file_name)){
                        $status['type']       = "success";
                        $status['message']    = true;
                        $status['file_name']  = $random_file_name;
                    }
                }else{
                    $status['type']     = "success";
                    $status['message']  = true;
                    $status['file']     = $file_array;
                }
            }
            
            return $status;
        }

        public function _removeFile($src)
        {
            if(file_exists($src)){
                return unlink($src);
            }
        }

        public function _getJoinData($what, $tabel, $join, $type, $where = '', $limit = '')
        {
            $stmt = $this->conn->prepare("SELECT $what FROM $tabel $join $where $limit");
            $stmt->execute();
            if($type == "fetch"){
                return [
                    "rowCount"  => $stmt->rowCount(),
                    "fetch"     => $stmt->fetch()
                ];
            }elseif($type == "fetchAll"){
                return [
                    "rowCount"  => $stmt->rowCount(),
                    "fetchAll"  => $stmt->fetchAll()
                ];
            }
        }

        public function _seen_ads($ads_id)
        {
            $update = $this->conn->prepare("UPDATE `ads` SET `seen_count` = `seen_count` + 1 WHERE `ads_settings_id` = ? && `status` = 1");
            $update->execute([$ads_id]);
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['start']) && isset($_GET['category'])):
        $start = $_GET['start'];
        $categoryid = trim(strip_tags($_GET['category']));
        $Functions = new Functions();
        echo json_encode($Functions->select("*", "`products`", "fetchAll", "WHERE `category_id` = $categoryid && `id` > $start", "LIMIT 13", "ORDER BY `id` ASC"));
    endif;
    
    
    