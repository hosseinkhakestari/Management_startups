<form action="" method="post" class="card fa-shadow text-right p-3 radius-10 mx-auto login-form">
    <h6>تایید رمز عبور</h6>
    <hr style="margin-right: -0.75em; margin-left: -0.75em;">
    <div class="form-group">
        <label>تکرار رمز عبور</label>
        <span id="require_star">*</span>
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input type="password" id="eng" name="password_repeat" placeholder="تکرار رمز عبور" class="form-control fa-back" required>
    </div>
    <div class="form-group">
        <label for=""></label>
        <input type="submit" name="confirm_pass" class="text-white w-100 brown-back cursor-p form-control" value="تایید">
    </div>
</form>