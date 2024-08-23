<?php 
    if(isset($settings)){
        if(isset($_SESSION['mainadmin'])){
?>
   <nav class="navbar navbar-light bg-light rounded-4 admin-nav mb-3 admin" style="z-index:99 !important;">
        <div class="container-fluid">
            <a class="navbar-brand me-0" href="#">
                <span class="fa fa-bars ms-2" onclick="toggleSide()"></span>
                بوابة الكفاءة
            </a>
            <div class="text-end">
                <a href="logout"><span class="fa fa-arrow-right-from-bracket"></span></a>
                <a href="settings"><span class="fa fa-gear"></span></a>
            </div>
        </div>
    </nav>
<?php } } ?>