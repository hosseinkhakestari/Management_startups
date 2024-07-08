<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/9/20
 * Time: 2:10 AM
 */
?>
<form action="" class="mtop-80" enctype="multipart/form-data" method="post">
    <div class="contariner-fluid padding-x-50 text-right">
        <?php
        show_messages();
        ?>
        <div class="row">
            <div class="col-12">
                <img src="<?php echo $image; ?>" alt="" class="member-image-upload ml-3">
                <input type="file" accept=".png,.jpeg,.jpg" class="d-none judge-img-input" name="judge_image[]">
                <input type="hidden" name="judge_image[]" class="member_image_input" value="<?php if (isset($added_image)){echo $image; } ?>">
                <button type="button" class="brown-back mr-1 text-white cursor-p btn add-judge-img-btn mt-3">انتخاب تصویر</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-3 form-group">
                <label>نام و نام خانوادگی</label>
                <span id="require_star">*</span>
                <input type="text" name="judge_name" value="<?php echo $judge_name; ?>" class="form-control" placeholder="نام و نام خانوادگی" required>
            </div>
            <div class="col-lg-3 form-group date_parent">
                <label>تاریخ تولد</label>
                <i class="far fa-calendar-alt"></i>
                <input type="text" name="birth_date" value="<?php echo $birth_date; ?>" class="form-control date_input bg-white" placeholder="تاریخ تولد" autocomplete="off" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 form-group">
                <label>تخصص</label>
                <span id="require_star">*</span>
                <input type="text" name="specialty" value="<?php echo $specialty; ?>" class="form-control" placeholder="تخصص" required>
            </div>
            <div class="col-lg-3 form-group">
                <label>معرف</label>
                <input type="text" name="presenter" value="<?php echo $presenter; ?>" class="form-control" placeholder="معرف">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 form-group">
                <label>نام کاربری</label>
                <span id="require_star">*</span>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control" placeholder="نام کاربری" maxlength="20" required>
            </div>
            <div class="col-lg-3 form-group">
                <label>دسته بندی</label>
                <span id="require_star">*</span>
                <select name="category" class="form-control" required>
                    <option value="" disabled selected hidden>دسته بندی</option>
                    <?php
                    foreach (startup_backs as $back){
                        echo "<option value='$back'>$back</option>";
                    }
                    ?>
                </select>
                <script>
                    $("select").val("<?php echo $category; ?>");
                </script>
            </div>
            <div class="col-12 text-left py-3">
                <input type="submit" name="save_judge" class="btn btn-200 brown-back text-white d-none save_judge" value="ذخیره">
                <input type="button" class="btn btn-200 brown-back text-white save_judge_btn" value="ذخیره">
            </div>
        </div>
    </div>
</form>
<div class="fa-shadow bg-white text-center p-4 radius-10 date_sec" style="position: fixed; top: calc(50% - 71px); left: 5%; width: 90%; display: none; z-index: 2;">
    <span class="close-form-button" style="position: absolute; top: 8px; right: 8px;"><i class="fa fa-plus"></i></span>
    <select name="" id="" class="form-control d-inline-block float-right" style="width: 30%;">
        <option value="" selected hidden disabled>روز</option>
        <?php
        for ($i = 1; $i <= 31; $i++){
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    <select name="" id="" class="form-control d-inline-block" style="width: 30%;">
        <option value="" selected disabled hidden>ماه</option>
        <?php
        for ($i = 1; $i <= 12; $i++){
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    <select name="" id="" class="form-control d-inline-block float-left" style="width: 30%;">
        <option value="" selected disabled hidden>سال</option>
        <?php
        for ($i = 1320; $i <= 1399; $i++){
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    <button class="btn brown-back d-block mx-auto mt-4 text-white btn-200 ">تایید</button>
</div>
<script src="/Views/js/add-judge.js?version=<?php echo rand(); ?>"></script>