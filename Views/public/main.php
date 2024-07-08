<div class="container  h-100 ">
    <div class="row text-center h-100">
        <div class="col-lg-4 col-md-4 col-sm-12 my-auto">
            <div class="bg-white py-4 px-2 w-75 mx-auto radius-10">
                <span class="font-weight-bold">بخش ارزیابی</span>
                <p class="font-weight-light my-4">بخش مربوط به مشاهده و بررسی طراح های ارسال شده</p>
                <a class="brown-back radius-10 text-white py-1 px-4 brown-link main-page-link" href="/judge">ورود</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 my-auto">
            <div class="bg-white py-4 px-2 w-75 mx-auto radius-10">
                <span class="font-weight-bold">بخش ثبت طرح</span>
                <p class="font-weight-light my-4">بخش ثبت استارتاپ و برنامه ها و طرح های کسب و کار</p>
                <a class="brown-back radius-10 text-white py-1 px-4 brown-link main-page-link" href="add-plan">ورود</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 my-auto text-center">
            <div class="bg-white py-4 px-2 w-75 mx-auto radius-10">
                <span class="font-weight-bold">بخش پیگیری طرح</span>
                <p class="font-weight-light my-4">پیگیری وضعیت طراح ارسالی با کد رهگیری</p>
                <a class="brown-back radius-10 text-white py-1 px-4 brown-link main-page-link" href="/tracking">ورود</a>
            </div>
        </div>
    </div>
</div>
<?php
if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['message']) && isset($_SESSION['show_message']) && $_SESSION['show_message'] == 1){
    ?>
    <script>
        var message = "<?php echo $_SESSION['message'][0]; ?>";
        $.alert({
            title: '',
            content: '<p style="text-align: right;">'+ message +'</p>',
            buttons: {
                باشه:function () {
                }
            }
        });
    </script>
    <?php
    unset($_SESSION["show_message"]);
}
?>