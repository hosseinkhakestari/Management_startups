<form action="" class="pt-4 padding-x-50 text-right add-plan-form" name="add-plan-form" method="post" enctype="multipart/form-data">
    <p class="text-justify pt-4 mt-4 row">جهت ثبت اطلاعات استارتاپ خود و بهره‌مندی از خدمات نوپا، لطفا فیلدهای زیر را با توجه و دقت تکمیل نمایید تا احتمال دعوت به مصاحبه حضوری و پذیرش استارتاپ شما افزایش یابد.</p>
    <?php
    if (isset($messages)){
        foreach ($messages as $message){
            echo "<p class='text-danger'>{$message}</p>";
        }
    }
    ?>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="title-color col-12">اطلاعات صاحب طرح</p>
        <div class="col-lg-6 form-group">
            <label>
                نام و نام خانوادگی
                <span id="require_star">*</span>
            </label>
            <input type="text" name="fl_name" class="form-control fa-back" placeholder="نام و نام خانوادگی" required value="<?php echo $owner_name; ?>">
        </div>
        <div class="col-lg-3 form-group">
            <label>
                جنسیت
                <span id="require_star">*</span>
            </label>
            <select name="owner_gender" class="form-control fa-back gender" required>
                <option value="" disabled selected hidden>جنسیت</option>
                <option value="مرد">مرد</option>
                <option value="زن">زن</option>
            </select>
            <script>
                $("select.gender").val("<?php echo $owner_gender; ?>");
            </script>
        </div>
        <div class="col-lg-3 form-group date_parent">
            <label>
                تاریخ تولد
                <span id="require_star">*</span>
            </label>
            <i class="far fa-calendar-alt"></i>
            <input type="text" class="form-control fa-back date_input" placeholder="تاریخ تولد" required name="birth_date" autocomplete="off" value="<?php echo $owner_birth; ?>">
        </div>
        <div class="form-group custom-col" style="width: 30%;">
            <label>
                شماره تماس
                <span id="require_star">*</span>
            </label>
            <input type="number" class="form-control fa-back none-spinner" placeholder="شماره تماس" required name="phone" value="<?php echo $owner_phone; ?>">
        </div>
        <div class="form-group custom-col" style="width: 30%;">
            <label>
                ایمیل
                <span id="require_star">*</span>
            </label>
            <input type="email" class="form-control fa-back" placeholder="ایمیل" required name="email" value="<?php echo $owner_email; ?>">
        </div>
        <div class="form-group custom-col" style="width: 40%;">
            <label>
                شهر محل سکونت
                <span id="require_star">*</span>
            </label>
            <select class="form-control fa-back city select2city" required name="city">
                <option value="" disabled selected hidden>شهر محل سکونت</option>
                <?php
                foreach (cities as $city){
                    echo "<option value='$city'>$city</option>";
                }
                ?>
            </select>
            <script>
                $("select.city").val("<?php echo $owner_city; ?>");
            </script>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="title-color col-12">اطلاعات استارتاپ</p>
        <div class="form-group custom-col" style="width: 17.5%;">
            <label>
                تعداد اعضای تیم
                <span id="require_star">*</span>
            </label>
            <input type="number" class="form-control fa-back" placeholder="تعداد اعضای تیم" required name="team_count" value="<?php echo $team_count; ?>">
        </div>
        <div class="form-group custom-col" style="width: 32.5%;">
            <label>
                میزان استفاده از امکانات مرکز نوآوری(به ساعت)
                <span id="require_star">*</span>
            </label>
            <select class="form-control fa-back use_hours" required name="use_hours">
                <option value="" disabled selected hidden>ساعت استفاده از امکانات مرکز</option>
                <?php
                foreach (use_hours as $hour){
                    echo "<option value='$hour'>$hour</option>";
                }
                ?>
            </select>
            <script>$("select.use_hours").val("<?php echo $use_hours; ?>");</script>
        </div>
        <div class="col-lg-6 form-group">
            <label>
                استارتاپ شما در چه مرحله‌ای قرار دارد؟
                <span id="require_star">*</span>
            </label>
            <select name="startup_level" class="fa-back form-control startup_level" required>
                <option value="" disabled selected hidden>وضعیت فعلی استارتاپ</option>
                <?php
                foreach (idea_levels as $level){
                    echo "<option value='$level'>$level</option>";
                }
                ?>
            </select>
            <script>$("select.startup_level").val("<?php echo $startup_level; ?>")</script>
        </div>
        <div class="form-group custom-col" style="width: 35%;">
            <label>
                چه مدتی است بر روی استارتاپ خود فعالیت دارید؟(ماه)
                <span id="require_star">*</span>
            </label>
            <input type="number" class="form-control fa-back" placeholder="مدت زمان فعالیت استارتاپ" required name="startup_term" value="<?php echo $startup_term; ?>">
        </div>
        <div class="form-group custom-col" style="width: 32.5%;">
            <label>
                زمینه فعالیت استارتاپ خود را مشخص کنید
                <span id="require_star">*</span>
            </label>
            <select name="startup_background" class="fa-back form-control startup_background" required>
                <option value="" disabled selected hidden>زمینه فعالیت استارتاپ</option>
                <?php
                foreach (startup_backs as $back){
                    echo "<option value='$back'>$back</option>";
                }
                ?>
            </select>
            <script> $("select.startup_background").val("<?php echo $startup_back; ?>") </script>
        </div>
        <div class="form-group custom-col" style="width: 32.5%;">
            <label>
                سرمایه تقریبی مورد نیاز(تومان)
                <span id="require_star">*</span>
            </label>
            <input type="text" class="fa-back form-control" id="amount_input" required name="fund" value="<?php echo $fund; ?>" placeholder="بودجه طرح">
        </div>
        <div class="form-group custom-col d-none" style="width: 32.5%;">
            <label>
                مرحله اجرایی طرح
                <span id="require_star">*</span>
            </label>
            <select name="idea_level" class="form-control fa-back idea_level">
                <option value="" disabled selected hidden>مرحله اجرایی طرح</option>
                <?php
                foreach (idea_levels as $level){
                    echo "<option value='$level'>$level</option>";
                }
                ?>
            </select>
            <script> $("select.idea_level").val("<?php echo $idea_level; ?>"); </script>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">استارتاپ</p>
        <div class="col-lg-6 form-group">
            <label>
                عنوان استارتاپ
                <span id="require_star">*</span>
            </label>
            <input type="text" class="form-control fa-back" name="idea_title" value="<?php echo $idea_title; ?>" placeholder="عنوان استارتاپ">
        </div>
        <div class="col-12 form-group">
            <label>
                ایده استارتاپ خود را شرح دهید
                <span id="require_star">*</span>
            </label>
            <textarea name="idea_exp" class="w-100 form-control fa-back text-area-exp" placeholder="ایده استارتاپ" required><?php echo $idea_exp; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">مشتریان</p>
        <div class="col-12 form-group">
            <label>
                مشتریان شما چه کسانی خواهند بود؟ و چه ارزشی برای مشتریان خلق می‌کند؟
                <span id="require_star">*</span>
            </label>
            <textarea name="customers" class="w-100 form-control fa-back text-area-exp customers" placeholder="مشتریان استارتاپ" required><?php echo $customers; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">مدل درآمدی</p>
        <div class="col-12 form-group">
            <label>
                از چه راهی درآمد کسب میکنید؟ اگر تا کنون درآمد کسب کرده اید مدل کسب درآمد را توضیح دهید
                <span id="require_star">*</span>
            </label>
            <textarea name="income_model" class="w-100 form-control fa-back text-area-exp" placeholder="روش درآمدی استارتاپ" required><?php echo $income_model; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">مدل اقتصادی (درآمد ها و هزینه ها)</p>
        <div class="col-12 form-group">
            <label>
                تخمینی از زمان و هزینه ی استارتاپ خود تا رسیدن به نقطه ی سربه‌سر دارید؟
                <span id="require_star">*</span>
            </label>
            <textarea name="economic_model" class="w-100 form-control fa-back text-area-exp" placeholder="هزینه های استارتاپ" required><?php echo $economic_model; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">رقبای داخلی و خارجی</p>
        <div class="col-12 form-group">
            <label>
                نمونه مشابه داخلی یا خارجی که آنها را رقیب استارتاپ خود می دانید را معرفی کنید(آدرس سایت نیز ذکر شود)
                <span id="require_star">*</span>
            </label>
            <textarea name="rival" class="w-100 form-control fa-back text-area-exp" placeholder="نمونه مشابه استارتاپ" required><?php echo $rival; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">نوآوری و خلاقیت</p>
        <div class="col-12 form-group">
            <label>
                نوآوری و خلاقیت استارتاپ شما در چه زمینه ای است؟
                <span id="require_star">*</span>
            </label>
            <textarea name="innovation" class="w-100 form-control fa-back text-area-exp" placeholder="ابداع و خلاقیت استارتاپ" required><?php echo $innovation; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">مزیت رقابتی</p>
        <div class="col-12 form-group">
            <label>
                مزیت رقابتی استارتاپ شما نسبت به رقبای اشاره شده چیست؟
                <span id="require_star">*</span>
            </label>
            <textarea name="rival_advantage" id="" class="w-100 form-control fa-back text-area-exp" placeholder="مزیت رقابتی استارتاپ" required><?php echo $rival_advantage; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">نمونه کار</p>
        <label class="col-12">در صورتی که نمونه ی اولیه‌ی محصول دارید، لینک آن را قرار دهید(نمونه اولیه‌ی محصول میتواند یک ویدئوی کوتاه مدت یک دقیقه ای از عملکرد برنامه یا محصول شما باشد)</label>
        <div class="col-lg-10 form-group">
            <textarea name="concept" id="eng" class=" form-control fa-back text-area-exp" placeholder="نمونه اولیه محصول"><?php echo $concept; ?></textarea>
        </div>
        <div class="col-lg-2 form-group text-center">
            <button class="brown-back text-white w-100 btn add-concept" type="button">فایل ضمیمه</button>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">سابقه سرمایه گذاری و شتابدهی</p>
        <div class="col-12 form-group">
            <label>
                آیا استارتاپ شما قبلا در دوره شتاب دهی یا پیش شتاب دهی دیگری حضور داشته است؟ نام دوره(ها) و مدت زمان آن را اعلام نمایید
                <span id="require_star">*</span>
            </label>
            <textarea name="push_history" class="w-100 form-control fa-back text-area-exp" placeholder="سابقه شتابدهی استارتاپ" required><?php echo $push_history; ?></textarea>
        </div>
        <div class="col-12 form-group">
            <label>
                آیا تا کنون از طریق جذب سرمایه‌گذار یا به طور شخصی اقدام به سرمایه گذاری بر روی استارتاپ کنونی‌تان نموده‌اید؟
                <span id="require_star">*</span>
            </label>
            <textarea name="investment_history" id="" class="w-100 form-control fa-back text-area-exp" placeholder="سابقه سرمایه گذاری استارتاپ" required><?php echo $investment_history; ?></textarea>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">ارائه</p>
        <label class="col-12">در صورتی که برای ارائه خود فایلی تهیه کرده اید، آنرا آپلود نمایید</label>
        <div class="col-lg-10 form-group">
            <textarea name="presentation" class=" form-control fa-back text-area-exp" placeholder="توضیحات در صورت نیاز"><?php echo $presentation; ?></textarea>
        </div>
        <div class="col-lg-2 form-group">
            <button class="brown-back text-white w-100 btn presentation-btn" type="button">فایل ضمیمه</button>
        </div>
    </div>
    <div class="row bg-white mt-4 p-4 radius-10 fa-shadow">
        <p class="col-12 title-color">معرفی اعضای تیم</p>
        <?php
        if (isset($members_name)){
        for($i = 0; $i < count($members_name); $i++){
            ?>
            <div class="col-lg-4 p-2 main-member-box">
                <div class="fa-shadow radius-10 p-3 font-size-13 member-box">
                    <img src="<?php echo $members_image[$i]; ?>" alt="" class="member-image">
                    <div class="d-inline-block member-det-parent">
                        <span>
                            نام و نام خانوادگی:
                            <?php echo $members_name[$i]; ?>
                        </span>
                        <br>
                        <span>
                            مدرک تحصیلی:
                            <?php echo $members_certificate[$i]; ?>
                        </span>
                        <br>
                        <span>
                            سن:
                            <?php echo $members_age[$i]; ?>
                        </span>
                    </div>
                    <p class="my-2">سوابق</p>
                    <p class="text-justify font-weight-light"><?php echo $members_history[$i]; ?></p>
                </div>
            </div>
            <input type='hidden' class='members_image' name='members_image[]' value="<?php echo $members_image[$i]; ?>">
            <input type='hidden' class='members_name' name='members_name[]' value="<?php echo $members_name[$i]; ?>">
            <input type='hidden' class='members_birth' name='members_birth[]' value="<?php echo $members_birth[$i]; ?>">
            <input type='hidden' class='members_age' name='members_age[]' value="<?php echo $members_age[$i]; ?>">
            <input type='hidden' class='members_certificate' name='members_certificate[]' value="<?php echo $members_certificate[$i]; ?>">
            <input type='hidden' class='members_history' name='members_history[]' value="<?php echo $members_history[$i]; ?>">
            <?php
        }
        }
        ?>
        <div class="col-lg-4 p-2 member-box-after">
            <div class="fa-shadow radius-10 add-member-box card">
                <p class="text-center h-100">
                    <button class="add-member-botton fa-back" type="button"><i class="fas fa-plus"></i></button>
                    <br>
                    <span class="title-color">افزودن عضو</span>
                </p>
            </div>
        </div>
    </div>
    <div class="row my-4 py-4 text-left" dir="ltr">
        <input class="brown-back text-white btn btn-200 py-2" type="submit" name="add-plan" value="ثبت">
    </div>
</form>
<div class="add-plan-back" style="display:none;"></div>
<div class="add-member-form bg-white radius-10 p-0 text-right" style="display: none;">
    <p class="fa-back w-100 m-0 text-center p-3 intro-p head-p">
        معرفی اعضای تیم
        <button class="close-form-button"><i class="fa fa-plus"></i></button>
    </p>
    <div class="pt-3 px-4 add-form-content">
        <img src="Views/images/member-default.png" alt="" class="member-image-upload">
        <input type="file" accept="image/*" style="display: none;" id="member-image-input">
        <button type="button" class="brown-back text-white mr-1 cursor-p border-0 py-1 px-2 btn add-member-image-btn">اپلود عکس</button>
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>
                        نام و نام خانوادگی
                        <span id="require_star">*</span>
                    </label>
                    <input type="text" class="form-control fa-back" placeholder="نام و نام خانوادگی">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>
                        تاریخ تولد
                        <span id="require_star">*</span>
                    </label>
                    <input type="text" class="form-control fa-back date_input" placeholder="تاریخ تولد" id="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>
                        مدرک تحصیلی
                        <span id="require_star">*</span>
                    </label>
                    <input type="text" class="form-control fa-back" placeholder="مدرک تحصیلی">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>سوابق</label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control fa-back text-area-exp" placeholder="سوابق"></textarea>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center fa-back p-2 m-0 head-p">
        <button class="brown-back cursor-p text-white py-2 btn save-member-btn btn-200" type="button">ذخیره</button>
    </p>
</div>
<div class="fa-shadow bg-white text-center p-4 radius-10 date_sec" style="position: fixed; top: calc(50% - 71px); left: 5%; width: 90%; display: none; z-index: 2;">
    <span class="close-date-form" style="position: absolute; top: 8px; right: 8px;"><i class="fa fa-plus"></i></span>
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
<?php
//list($type, $data) = explode(';', $data);
//list(, $data)      = explode(',', $data);
//$data = base64_decode($data);
//var_dump(file_put_contents('image.png', $data));
?>
<!--<script type="text/javascript">-->
<!--    $(document).ready(function() {-->
<!--        $(".date_input").persianDatepicker({-->
<!--            altField: '.date_input',-->
<!--            altFormat: "YYYY/MM/DD",-->
<!--            observer: true,-->
<!--            format: 'YYYY/MM/DD',-->
<!--            initialValue: false,-->
<!--            initialValueType: 'persian',-->
<!--            autoClose: true,-->
<!--            maxDate: 'today',-->
<!--            autoClose: true,-->
<!--            viewMode: 'year'-->
<!--        });-->
<!--        $("#member_birth").persianDatepicker({-->
<!--            altField: '#member_birth',-->
<!--            altFormat: "YYYY/MM/DD",-->
<!--            observer: true,-->
<!--            format: 'YYYY/MM/DD',-->
<!--            initialValue: false,-->
<!--            initialValueType: 'persian',-->
<!--            autoClose: true,-->
<!--            maxDate: 'today',-->
<!--            autoClose: true,-->
<!--            viewMode: 'year'-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script src="Views/js/add-plan-member.js?version=<?php echo rand(); ?>"></script>
<script language="javascript" type="text/javascript">
    window.onbeforeunload = function()
    {
        return "Are you sure want to close";
    }
</script>