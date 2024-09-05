<?php
    $settings = true;
    $page_title = "Zara Euphoria Box";
    require("includes/components/header.php");
    require('init.php');
?>

    <?php include('includes/components/main-header.php'); ?>

    <style>
        .header img{
            height: 550px;
        }
        @media(max-width:800px){
            .header img{
                height:300px;
            }
        }
    </style>

    <section class="header position-relative mt-2">
        <div class="container">
            <div id="carouselExampleFade" class="carousel slide carousel-fade overflow-hidden autoplay rounded-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= $url ?>/includes/uploads/images/slide1.jpg" class="d-block w-100" alt="image1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $url ?>/includes/uploads/images/slide2.jpg" class="d-block w-100" alt="image1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $url ?>/includes/uploads/images/slide3.jpg" class="d-block w-100" alt="image1">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    
    <section class="web_items main_section py-5" id="categories_products">
        <div class="container">
            <div class="mb-4 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s">
                <h1 class="text-center fw-bold mb-3">Zara Euphoria Box</h1>
                <div class="_headerBorder1 mb-2"></div>
                <div class="_headerBorder2"></div>
            </div>
            <div class="row">
                <!-- Categories -->
                <!-- <div class="col-md-12 mb-3">
                    <div class="owl-carousel owl-theme owl-carousel-services show-services-cards pe-3 ps-3 wow fadeInDown" data-wow-duration="1s" data-wow-delay=".1s">
                        <?php foreach($categories['fetchAll'] as $category): ?>
                            <a href="<?= $url ?>/all-products?category=<?= $category['id'] ?>">
                                <div class="item pt-2 pb-2">
                                    <div class="one-service w-100 rounded-3 d-flex justify-content-between align-items-center p-4">
                                        <div class="m-0 text-small"><?= $category['name_ar'] ?></div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div> -->
                <!-- Items -->
                <div class="col-lg-12 col-12">
                    <div class="row">
                        <?php
                            foreach($categories['fetchAll'] as $category):
                                $category_id = $category['id'];
                                $getProducts = $Functions->select("*", "`products`", "fetchAll", "WHERE `category_id` = $category_id && `status` = 1", "LIMIT 9", "ORDER BY RAND()");
                                if($getProducts['rowCount'] > 0):
                        ?>
                                <div class="col-md-12 mt-3">
                                    <div class="title-services d-flex justify-content-between align-items-center">
                                        <div class="card-header-title mb-0 fw-bold"><?= $category['name_ar'] ?></div>
                                        <a href="<?= $url ?>/all-products?category=<?= $category_id ?>" class="text-muted fs-7"><u>عرض المزيد</u></a>
                                    </div>
                                    <div class="owl-carousel owl-theme wow fadeIn" data-wow-duration="1s" data-wow-delay=".1s">
                        <?php
                                    foreach($getProducts['fetchAll'] as $product):
                                        $first_image = explode(',', $product['images'])[0];
                        ?>
                                        <div class="item pt-3 pb-3">
                                            <div class="_item_image w-100 d-flex justify-content-center align-items-center position-relative">
                                                <div class="_rgba w-100 h-100 position-absolute"></div>
                                                <img src="<?= $url ?>/includes/uploads/products/images/<?= $first_image ?>" alt="item">
                                            </div>
                                            <div class="item_description p-3  mt-1">
                                                <a href="<?= $url ?>/products?pn=<?= str_replace([' ',',','.', '@','،'], '-', $product['name']) ?>&pid=<?= $product['id'] ?>" class="h6"><?= strlen($product['name']) > 40 ? mb_substr($product['name'], 0, 40).'...' : $product['name'] ; ?></a>
                                                <div class="_more_details d-flex justify-content-between align-items-center gap-2 mt-2">
                                                    <div class="fw-bold h6 mt-0 rounded-4 ps-3 pe-0 h-100">EGP <?= number_format($product['price'], 2); ?></div>
                                                    <!-- <a href="" class="btn btn-default rounded-4 w-100">
                                                        شراء
                                                    </a> -->
                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach; ?>
                                    <div class="item pt-3 pb-3">
                                        <div class="_item_image w-100 d-flex justify-content-center shadow-sm align-items-center position-relative">
                                            <mark><a href="<?= $url ?>/all-products?category=<?= $category_id ?>"> عرض المزيد <span class="fa fa-arrow-left me-2 mt-1"></span></a></mark>
                                        </div>
                                    </div>    
                                </div>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/components/main-footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?= $url ?>/includes/layouts/js/wow.min.js"></script>
    <script src="<?= $url ?>/includes/layouts/js/owl.carousel.js"></script>
    <script src="<?= $url ?>/includes/layouts/js/owl.navigation.js"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        function _getSection()
        {
            window.scrollTo({
                top: document.getElementById('categories_products').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
    <script>
        $('.owl-carousel').owlCarousel({
            rtl:true,
            loop:false,
            dots:false,
            margin:25,
            autoPlay:false,
            lazyLoad:true,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                370:{
                    stagePadding: 40,
                    items:1
                },
                500:{
                    stagePadding: 90,
                    items:1
                },
                900:{
                    items:2
                },
                1050:{
                    items:4
                },
            }
        });
    </script>
    <script>
        window.onload = function (){
            const _svgClip = document.querySelector('._svgClip');
            _svgClip.classList.add('_svgToggled');
            const container = document.querySelector('.header');
            const img       = document.querySelector('.header ._imageContent img');
            container.addEventListener('mousemove', (event) => {
                let x = event.screenX / 60, y = event.screenY / 60;
                img.style.transform = `translateX(${x}px) translateY(${y}px)`;
            });
        }
    </script>

<?php include('includes/components/footer.php'); ?>