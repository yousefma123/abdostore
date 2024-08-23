<?php
    if(isset($settings)){
        if(isset($_SESSION['mainadmin'])){
?>
        <aside class="admin-sidebar p-2">
            <div class="bars" onclick="toggleSide()">
                <span class="fa fa-arrow-right"></span>
            </div>
            <ul>
                <a href="home">
                    <li class="<?= $page_name == 'dashboard' ? 'active' : '' ?>">
                        <span class="fa fa-home"></span>
                        الرئيسية
                    </li>
                </a>
                <a href="categories">
                    <li class="<?= $page_name == 'categories' ?  'active' : '' ?>">
                        <span class="fa fa-bars"></span>
                        الأقسام
                    </li>
                </a>
                <a href="products">
                    <li class="<?= $page_name == 'products' ?  'active' : '' ?>">
                        <span class="fa fa-sitemap"></span>
                        المنتجات
                    </li>
                </a>
                <a href="settings">
                    <li class="<?= $page_name == 'settings' ?  'active' : '' ?>">
                        <span class="fa fa-gear"></span>
                        الإعدادات
                    </li>
                </a>
                <a href="<?= $url ?>/">
                    <li>
                        <span class="fa fa-diagram-project"></span>
                        المتجر
                    </li>
                </a>
            </ul>
        </aside>
<?php }} ?>