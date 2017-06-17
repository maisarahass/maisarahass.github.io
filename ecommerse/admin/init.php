<?php

include 'connect.php';

//routes
$lang = 'incloude/languages/';
$tpl = 'incloude/templets/';
$func = 'incloude/function/';
$css = 'layout/css/';
$js = 'layout/js/';



// include the importamt files  
include $lang . 'english.php'; // لازم يكون هو الملف الاول ولي فوق عشان يعمللكاش مشاكل
include $func . 'func.php';
include $tpl . 'header.php';


if(!isset($nonavbar)){ // بشوف اذا الصفحة فيها متغير اسمو نونافبار يعني بلزمش يستعدعي الناف بار فيها لكن لو لقاش فيها المتغير بيقوم وبيستدعي ملف النافبار
    include $tpl . 'navbar.php';

}
