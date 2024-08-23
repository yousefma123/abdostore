<?php
    if(isset($_GET['category']) && is_numeric($_GET['category'])):
    require('init.php');
    $category_id = $_GET['category'];
    $getProducts = $Functions->_getJoinData(
        "`products`.*, `categories`.name_ar",
        "`products`",
        "INNER JOIN `categories` ON `categories`.id = `products`.category_id",
        "fetchAll",
        "WHERE `products`.category_id = $category_id && `categories`.status = 1 && `products`.status = 1",
        "LIMIT 12"
    );
    if($getProducts['rowCount'] > 0):
        $settings = true;
        $page_title = "بوابة الكفاءة | ".$getProducts['fetchAll'][0]['name_ar']."";
        require("includes/components/header.php");
?>
    <?php include('includes/components/main-header.php'); ?>
    <section class="web_items main_section">
        <div class="container">
            <div class="mb-4 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s">
                <h1 class="text-center fw-bold mb-3"><?= $getProducts['fetchAll'][0]['name_ar'] ?></h1>
                <div class="_headerBorder1 mb-2"></div>
                <div class="_headerBorder2"></div>
            </div>
            <div class="row">
                <!-- Items -->
                <div class="col-lg-12 col-12">
                    <div class="row" id="products_box">
                        <?php foreach($getProducts['fetchAll'] as $product): $first_image = explode(',', $product['images'])[0]; ?>
                        <div class="col-md-3 mt-3 wow fadeIn all_products" data-id="<?= $product['id'] ?>" data-wow-duration="1s" data-wow-delay=".1s">
                            <div class="item pt-3 pb-3">
                                <div class="_item_image w-100 d-flex justify-content-center align-items-center position-relative">
                                    <div class="_rgba w-100 h-100 position-absolute"></div>
                                    <img src="<?= $url ?>/includes/uploads/products/images/<?= $first_image ?>" alt="item">
                                </div>
                                <div class="item_description p-3 shadow-sm mt-3">
                                    <div class="fw-bold h5"><?= strlen($product['name']) > 40 ? mb_substr($product['name'], 0, 40).'...' : $product['name'] ; ?></div>
                                    <div class="_more_details d-flex justify-content-between align-items-center gap-2 mt-2">
                                        <div class="fw-bold h5 mt-0 rounded-4 ps-3 pe-0 h-100"><sub class="fs-7 fw-bold">SAR </sub><?= number_format($product['price'], 2); ?></div>
                                        <a href="products?pn=<?= str_replace([' ',',','.', '@','،'], '-', $product['name']) ?>&pid=<?= $product['id'] ?>" class="btn btn-default rounded-4 w-100">
                                            شراء
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if($Functions->select("`id`", "`products`", "fetch", "WHERE `category_id` = $category_id && `status` = 1")['rowCount'] > 12): ?>
                <button class="btn btn-default rounded-4 mt-3" id="getMoreProducts" onclick="_request()">عرض المزيد <span class="fa fa-arrow-left me-2"></span></button>
            <?php endif; ?>
        </div>
    </section>

    <?php include('includes/components/main-footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?= $url ?>/includes/layouts/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        function _request()
        {
            const xhr = new XMLHttpRequest();
            const all_products = document.querySelectorAll('.all_products');
            const ids = [];
            all_products.forEach( (item) => {
                ids.push(item.getAttribute('data-id'));
            });
            xhr.onload = function(){
                if(this.status == 200){
                    let data = JSON.parse(this.responseText);
                    const products_box = document.getElementById('products_box');
                    if(data['fetchAll'].length < 13){
                        document.getElementById('getMoreProducts').remove();
                    }
                    if(data['fetchAll'].length >= 13){
                        data['fetchAll'].pop();
                    }
                    data['fetchAll'].forEach( (product) => {
                        let first_image = product.images.split(',')[0];
                        let col = document.createElement('div');
                        col.className = "col-md-3 mt-3 wow fadeIn all_products";
                        col.setAttribute('data-id', product.id);
                        col.setAttribute('data-wow-duration', '1s');
                        col.setAttribute('data-wow-delay', '0.1s');
                        col.innerHTML = 
                        `
                            <div class="item pt-3 pb-3">
                                <div class="_item_image w-100 d-flex justify-content-center align-items-center position-relative">
                                    <div class="_rgba w-100 h-100 position-absolute"></div>
                                    <img src="<?= $url ?>/includes/uploads/products/images/${first_image}" alt="item">
                                </div>
                                <div class="item_description p-3 shadow-sm mt-3">

                                    <div class="fw-bold h5">${product.name.length > 40 ?  product.name.substr(0, 40)+'...' : product.name}</div>
                                    <div class="_more_details d-flex justify-content-between align-items-center gap-2 mt-2">
                                        <div class="fw-bold h5 mt-0 rounded-4 ps-3 pe-0 h-100"><sub class="fs-7 fw-bold">SAR </sub>${(product.price*1).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                                        <a href="products?pn=${product.name.replace(/[_ , ، .@]/g, '-')}=&pid=${product.id}" class="btn btn-default rounded-4 w-100">
                                            شراء
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        products_box.appendChild(col);
                    });
                }
            }
            xhr.open('GET', `classes/Functions.php?start=${Math.max.apply(Math, ids)}&category=<?= $_GET['category'] ?>`);
            xhr.send();
        }
    </script>

<?php 
            include('includes/components/footer.php');
        endif;
    endif; 
?>