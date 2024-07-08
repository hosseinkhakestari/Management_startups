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
    <?php
    if (isset($homepage) && $homepage == 1){
        ?>
        <style>
            body, html{
                width: 100%;
                height: 100%;
                position: relative;
                overflow: hidden;
                background-image: url("/Views/images/home.jpeg");
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
        <?php
    }elseif (isset($login_page) && $login_page == 1){
        ?>
        <style>
            body,html{
                width: 100%;
                height: 100%;
                position: relative;
                overflow: hidden;
            }
        </style>
        <?php
    }elseif (isset($tracking_code_page)){
        ?>
        <style>
            body{
                background: white !important;
            }
        </style>
        <?php
    }
    ?>
    <link rel="stylesheet" href="/Views/js/PersianDatePicker/persian-datepicker.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="/Views/js/PersianDatePicker/persian-date.min.js"></script>
    <script src="/Views/js/PersianDatePicker/persian-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <?php
    if (isset($useselect2)){
        ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <?php
    }
    ?>
    <title><?php echo $page_title; ?></title>
</head>
<body>
<div class="loader-back"></div>
<div class="loader"></div>
<?php
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