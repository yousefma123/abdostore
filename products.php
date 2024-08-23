<?php
    $settings = true;
    require('init.php');
    if(isset($_GET['pid']) && is_numeric($_GET['pid'])):
        $pid = trim(strip_tags($_GET['pid']));
        $getProduct = $Functions->_getJoinData(
            "`products`.*, `categories`.*",
            "`products`",
            "INNER JOIN `categories` ON `categories`.id = `products`.category_id",
            "fetch",
            "WHERE `products`.id = $pid && `products`.status = 1 && `categories`.status = 1"
        );
    else:
        header("location:index");
        exit;
    endif;
    if($getProduct['rowCount'] == 1):
        $page_title = $getProduct['fetch']['name'];
        $og_description = $getProduct['fetch']['name'];
        $product_images = explode(',', $getProduct['fetch']['images']);
        $og_image = "/includes/uploads/products/images/$product_images[0]";
        require("includes/components/header.php");
        include('includes/components/main-header.php');
?>
<style>
    .show_images_clicked{
        z-index: 99999;
        background: rgba(0, 0, 0, 0.8);
        top: 0;
        right: 0;
        display:none;
    }
    .show_images_clicked button{
        position: absolute;
        top: 20px;
        left: 8%;
        color: #fff;
        font-size:35px
    }
    .show_images_clicked img{
        max-width:80%;
        max-height:80%;
    }
</style>
    <section class="product_info mt-5">
        <div class="show_images_clicked w-100 h-100 position-fixed justify-content-center align-items-center">
            <button class="btn btn-default fa fa-times" onclick="_displayBox()"></button>
            <img src="" alt="بوابة الكفاءة">
        </div>
        <div class="container ps-4 pe-4 pt-2">
            <div class="row">
                <div class="col-md-5 mb-4">
                    <div class="product_slider row">
                        <div class="right_images wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s">
                            <?php
                                foreach($product_images as $key => $image):
                            ?>
                                <div class="one_image w-100 rounded-2 text-center mb-3 <?= $key == 0 ? 'active' : '' ;?>" onclick="_getImage(this)">
                                    <img class="w-100 h-100 rounded-2" src="<?= $url ?>/includes/uploads/products/images/<?= $image ?>" alt="<?= $getProduct['fetch']['name'] ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left_images d-flex justify-content-center align-items-center rounded-2 mx-auto text-center shadow-sm wow fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                            <img id="images_slider" src="<?= $url ?>/includes/uploads/products/images/<?= $product_images['0'] ?>" alt="<?= $getProduct['fetch']['name'] ?>">
                        </div>
                        <div class="col-12 text-left order_now wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                            <?php
                                $text = "بخصوص هـذا المنتج: ".$url."/products?pn=".$_GET['pn']."&pid=".$_GET['pid']."";
                            ?>
                            <a href="https://wa.me/<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `key` = 'phone'")['fetch']['value']; ?>/?text=<?= $text ?>" class="btn btn-primary p-3 mt-4 shadow-sm" target="_blank">طلب المنتج</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-4">
                    <div class="product_tap_info w-100">
                        <h1 class="fw-bold h2 w-75 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.3s"><?= $getProduct['fetch']['name'] ?></h1>
                        <div class="model mt-4 text-muted text-small wow fadeInDown" data-wow-duration="1s" data-wow-delay=".3s"><span class="ms-1">رقم الموديل:</span> <?= $getProduct['fetch']['model'] ?></div>
                        <div class="price fw-bold h4 mt-3 wow fadeInDown" data-wow-duration="1s" data-wow-delay=".4s">EGY <?= number_format($getProduct['fetch']['price'], 2) ?> <span class="tax text-muted fs-7 fw-bold me-2">(شامل الضرائب)</span></div>
                        <div class="card details mt-4 shadow-sm rounded-4 wow fadeInDown" data-wow-duration="1s" data-wow-delay=".4s">
                            <div class="card-body pt-3">
                                <span class="rounded-4 p-2 fs-7 ps-3 pe-3 title">المواصفات</span>
                                <div class="row mt-3">
                                    <?php
                                        $details_keys   = explode(',', $getProduct['fetch']['details_keys']);
                                        $details_values = explode(',', $getProduct['fetch']['details_values']);
                                        foreach($details_keys as $key => $detail):
                                    ?>
                                        <div class="col-md-6 mt-3">
                                            <div class="one_info text-muted w-100 d-flex justify-content-between align-items-center p-3 rounded-3">
                                                <div><?= $detail ?></div>
                                                <div><?= $details_values[$key] ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning rounded-4 shadow-sm mt-4 p-2 d-flex align-items-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                            <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none">
                                <path d="M4.4003 8.30438H19.7049V20.0687H4.4003V8.30438Z" fill="#FEEE00" stroke="#404553" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5501 9.01128C20.5501 10.1539 19.5931 11.0802 18.4126 11.0802C17.5579 11.0802 16.8205 10.5948 16.4784 9.8932C16.3951 9.72219 16.1551 9.72219 16.0717 9.8932C15.7297 10.5948 14.9922 11.0802 14.1376 11.0802C13.2829 11.0802 12.5455 10.5948 12.2034 9.8932C12.1201 9.72219 11.8801 9.72219 11.7967 9.8932C11.4547 10.5948 10.7172 11.0802 9.86257 11.0802C9.00794 11.0802 8.27047 10.5948 7.92844 9.8932C7.84507 9.72219 7.60507 9.72219 7.52171 9.8932C7.17968 10.5948 6.44221 11.0802 5.58757 11.0802C4.40707 11.0802 3.45007 10.1539 3.45007 9.01128L5.4977 4.20042C5.59592 4.03407 5.77868 3.9314 5.97663 3.9314H18.0235C18.2215 3.9314 18.4042 4.03407 18.5024 4.20042L20.5501 9.01128Z" fill="white" stroke="#404553"/>
                                <path d="M13.083 20.0687V13.4612H16.8591V17.7552" stroke="#404553" stroke-linecap="round"/>
                                <path d="M7.013 14.3639H10.513" stroke="#404553" stroke-linecap="round"/>
                            </svg>
                            <div class="fw-bold">المنتج متاح ويمكنك طلبه الآن </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    
    <?php include('includes/components/main-footer.php'); ?>

    <script src="<?= $url ?>/includes/layouts/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        window.onload = function(){
            let slider = document.getElementById('images_slider'),
                images = "<?= $getProduct['fetch']['images'] ?>".split(','),
                rights = document.querySelectorAll('.one_image'),
                _count = 1;
            setInterval(() => {
                if(_count == images.length){
                    _count = 0;
                }
                slider.setAttribute('src', "<?= $url ?>/includes/uploads/products/images/"+images[_count]);
                rights.forEach( (item) => {
                    item.classList.remove('active');
                });
                rights[_count].classList.add('active');
                _count ++;
            }, 5000);
        }
        function _getImage(elem)
        {
            const imageSRC  = elem.querySelector('img').getAttribute('src');
            const box       = document.querySelector('.show_images_clicked');
            box.querySelector('img').setAttribute('src', imageSRC);
            box.style.display = 'flex';
            console.log(imageSRC);
        }
        function _displayBox()
        {
            const box   = document.querySelector('.show_images_clicked');  
            box.style.display = 'none';
        }
    </script>

<?php 
        include('includes/components/footer.php'); 
    else:
        echo 'Not Found';
    endif;
?>