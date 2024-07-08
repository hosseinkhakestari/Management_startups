<div class="container-fluid text-center">
    <div class="row mtop-80">
        <div class="col-12 font-weight-bold">
            به سامانه نوپا خوش آمدید
        </div>
        <div class="col-12 mtop-80 mb-4">
            به منظور پیگیری وضعیت طرح ارسالی، کد رهگیری خود را وارد نمایید
        </div>
        <div class="col-12 mt-4 text-center">
            <form action="" method="post" class="fa-shadow card px-3 radius-10 mx-auto" style="width: 250px;">
                <p class="font-size-13 my-4">کد رهگیری</p>
                <div class="form-group my-0">
                    <input type="number" name="tracking_code" class="none-spinner form-control fa-back" placeholder="کد رهگیری" required>
                </div>
                <div class="form-group my-4">
                    <input type="submit" name="get_plan_status" class="brown-back rounded text-white btn px-4" value="ادامه">
                </div>
            </form>
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