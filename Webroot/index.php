<?php
ob_start();
define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
//cities list
define("cities",["تهران", "البرز", "اصفهان", "فارس", "خراسان"]);
//use hours
define("use_hours", ["کمتر از ۱۵ ساعت در هفته","۱۵ تا ۳۰ ساعت در هفته","بیش از ۳۰ ساعت در هفته"]);
//startap levels
define("startup_levels", ["ارزیابی شده", "ارزیابی نشده"]);
//startup backgrounds - categories
define("startup_backs", ["مالی", "کشاورزی", "سلامت", "صنعت", "ورزشی"]);
//idea level
define("idea_levels", ["ایده و طرح کسب و کار", "در حال اجرا", "دارای نمونه اولیه یا محصول"]);
//judge questions
define("judge_ques", ["مشکلی که کسب و کار مبتنی بر طرح، مدعی حل آن است را چگونه ارزیابی می‌کنید؟", "شیوه کسب درآمد این طرح چقدر عملی است؟", "نیازمندی‌های اجرای طرح چقدر مناسب تشخیص داده شده؟", "تشخیص هزینه های اجرای طرح را چگونه ارزیابی می‌کنید؟"]);
require(ROOT . 'Config/core.php');
require(ROOT . 'router.php');
require(ROOT . 'request.php');
require(ROOT . 'dispatcher.php');
require (ROOT . 'include/functions.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();
?>