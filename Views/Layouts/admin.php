<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/Views/css/style.css?ver=<?php echo rand(); ?>">
    <script src="https://kit.fontawesome.com/f01440e807.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Views/js/PersianDatePicker/persian-datepicker.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="/Views/js/PersianDatePicker/persian-date.min.js"></script>
    <script src="/Views/js/PersianDatePicker/persian-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <title><?php echo $page_title; ?></title>
    <?php
    if (isset($useselect2)){
        ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <?php
    }
    ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white fa-shadow fixed-top padding-x-50" style="z-index: 2 !important;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav text-right pr-0">
            <li class="nav-item recent">
                <a class="nav-link" href="/admin/recent">طرح های جدید</a>
                <span class="nav-link-bb" style="transition: width 0.5s;"></span>
            </li>
            <li class="nav-item rejected">
                <a class="nav-link" href="/admin/rejected">طرح های رد شده</a>
                <span class="nav-link-bb" style="transition: width 0.5s;"></span>
            </li>
            <li class="nav-item sended">
                <a class="nav-link" href="/admin/sended">طرح های ارسال شده</a>
                <span class="nav-link-bb" style="transition: width 0.5s;"></span>
            </li>
            <li class="nav-item rated">
                <a class="nav-link" href="/admin/rated">طرح های ارزیابی شده</a>
                <span class="nav-link-bb" style="transition: width 0.5s;"></span>
            </li>
            <li class="nav-item add-judge">
                <a class="nav-link" href="/admin/add_judge">معرفی ارزیاب</a>
                <span class="nav-link-bb" style="transition: width 0.5s;"></span>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    گزارشات
                </a>
                <div class="dropdown-menu text-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/admin/plans_report">طرح ها</a>
                    <a class="dropdown-item" href="/admin/judges_report">ارزیاب ها</a>
                    <a class="dropdown-item" href="/admin/financial_report">مالی</a>
                </div>
            </li>
            <li class="nav-item dropdown financial">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    عملیات مالی
                </a>
                <div class="dropdown-menu text-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/admin/plans_financial">طرح ها</a>
                    <a class="dropdown-item" href="/admin/judges_financial">ارزیاب ها</a>
                    <a class="dropdown-item" href="/admin/cats_financial">دسته بندی ها</a>
                </div>
            </li>
        </ul>
    </div>
    <div id="profile_det">
        <ul class="navbar-nav text-right">
            <li class="nav-item dropdown p-0">
                <a class="nav-link dropdown-toggle username_drop px-2 m-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 160px; background: #b4b4b4; padding-right: 10px !important; margin-left: 10px; border-radius: 20px;">
                    <i class="fas fa-user-circle" style="font-size: 20px; vertical-align: middle; color: white;"></i>
                    <?php echo $_SESSION["Uname"]; ?>
                </a>
                <div class="dropdown-menu text-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">تغییر رمز عبور</a>
                    <a class="dropdown-item" href="#">پیام ها</a>
                    <a class="dropdown-item" href="/logout">خروج</a>
                </div>
            </li>
        </ul>
    </div>
<!--    <form class="form-inline my-2 my-lg-0 mr-auto">-->
<!--        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
<!--        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
<!--    </form>-->
</nav>
<div id="logo_parent" class="padding-x-50">
    <img src="http://stshow.ir/wp-content/uploads/2016/03/logo-header.png" alt="" id="logo">
</div>
<div class="loader-back"></div>
<div class="loader"></div>
<?php
if (isset($active)){
    ?>
    <script>
        document.getElementsByClassName("<?php echo $active; ?>")[0].classList.add("active");
    </script>
    <?php
}
echo $content_for_layout;
?>
<script src="/Views/js/functions.js?version=<?php echo rand(); ?>"></script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>