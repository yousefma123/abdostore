<?php 
    if(isset($settings)){
?>

    <!-- <nav class="navbar navbar-expand-lg shadow-none wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s" style="height:70px;background: transparent;z-index: 99999;">
        <div class="container d-flex justify-content-between">
            
            <span class="fa fa-bars _bar h4"></span>
        </div>
    </nav> -->

    <nav class="navbar navbar-expand-lg bg-white shadow-none wow fadeInDown py-3" data-wow-duration="1s" data-wow-delay="0s" style="background: transparent;z-index: 99999;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= $url ?>"> Zara Euphoria Box </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $url ?>">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">تواصل معنا</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            الأقسام
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php 
                                $categories = $Functions->select("`name_ar`, `id`", "`categories`", "fetchAll", "WHERE `status` = 1", "LIMIT 50", "ORDER BY `arrangement` ASC");
                                foreach($categories['fetchAll'] as $category):
                            ?>
                                <li><a class="dropdown-item" href="<?= $url ?>/all-products?category=<?= $category['id'] ?>"><?= $category['name_ar'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<?php } ?>