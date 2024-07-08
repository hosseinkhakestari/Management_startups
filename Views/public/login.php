<form action="" method="post" class="card fa-shadow text-right p-3 radius-10 mx-auto login-form">
    <h6>ورود به سامانه</h6>
    <hr style="margin-right: -0.75em; margin-left: -0.75em;">
    <div class="form-group">
        <label>نام کاربری</label>
        <span id="require_star">*</span>
        <input type="text" id="eng" name="username" value="<?php echo $username;?>" placeholder="نام کاربری" class="form-control fa-back" required>
    </div>
    <div class="form-group">
        <label>رمز عبور</label>
        <span id="require_star">*</span>
        <input type="password" id="eng" name="password" placeholder="رمز عبور" class="form-control fa-back" required>
    </div>
    <div class="form-froup text-left font-size-13">
        <a href="" style="border-bottom: 1px solid cornflowerblue; text-decoration: none; display: block; height: 18px; width: 168px; float: left;">رمز عبور خود را فراموش کرده ام</a>
    </div>
    <div class="form-group">
        <label></label>
        <input type="submit" name="login" class="text-white w-100 brown-back cursor-p btn" value="ورود">
    </div>
</form>
<?php require_once ROOT . "Views/public/alert_message.php"; ?>