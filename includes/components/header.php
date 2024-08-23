
<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
if(@$settings == true){ 
    $url = "http://localhost:8080/abdostore";    
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($page_title) && !empty($page_title)){echo $page_title;}else{echo 'Zara Euphoira Box';}?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Zara Euphoira Box">
    <meta name="theme-color" content="#5f61e2" />
    <meta name="description" content="منصة لبيع وشراء منتجات الملابس الحديثة بخصومات مرتفعة علي مدار السنة. ملابس - أحذية - شنط" />
    <meta property="og:site_name" content="Zara Euphoira Box" />
    <meta property="og:title" content="Zara Euphoira Box <?= isset($og_title) ? ' | '. $og_title : '' ;?>" />
    <meta property="og:description" content="<?= isset($og_description) ? $og_description : ' ' ;?>" />
    <meta property=“og:type” content="<?= isset($og_type) ? $og_type : 'website' ;?>" />
    <meta property="og:image" content="<?= isset($og_image) ? $url.$og_image : $url.'/includes/uploads/images/store.svg' ;?>" />
    <meta name="twitter:title" content="Zara Euphoira Box <?= isset($og_title) ? ' | '. $og_title : '' ;?>" />
    <meta name="twitter:description" content="<?= isset($og_description) ? $og_description : ' ' ;?>" />
    <meta name="twitter:image" content="<?= isset($og_image) ? $url.$og_image : $url.'/includes/uploads/images/store.svg' ;?>" />
    <meta name="keywords" content="Zara Euphoira Box, zara store, store, zara box,Euphoira Box">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $url ?>/includes/uploads/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $url ?>/includes/uploads/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $url ?>/includes/uploads/images/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/animate.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/style.css">
</head>
<body dir="rtl" <?= isset($background) ?  "style='background:$background !important'" : '' ; ?>>
<?php } ?>