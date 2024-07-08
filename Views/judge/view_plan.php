<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/7/20
 * Time: 1:34 AM
 */
?>
<div class="container-fluid padding-x-50 mtop-80 text-right">
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="fa-shadow radius-10 p-3 bg-white">
                <p>
                    تاریخ ثبت طرح :
                    <?php
                    echo convert_datetime($time);
                    ?>
                </p>
                <p>
                    برآورد هزینه اجرا :
                    <?php
                    echo convert_amount($fund);
                    ?>
                    تومان
                </p>
                <p>
                    <span>حوزه فعالیت طرح</span><br>
                    <span class="title-color"><?php echo $startup_back; ?></span>
                </p>
                <p>
                    <span>تعداد اعضای تیم</span><br>
                    <span class="title-color"><?php echo $team_count . " نفر"; ?></span>
                </p>
                <p>
                    <span>مدت فعالیت روی استارتاپ</span><br>
                    <span class="title-color"><?php echo $startup_term; ?></span>
                </p>
                <p>
                    <span>وضعیت فعلی استارتاپ</span><br>
                    <span class="title-color"><?php echo $idea_level; ?></span>
                </p>
                <?php
                $concept_files = unserialize($concept_files);
                if (!empty($concept_files)){
                    ?>
                    <p>
                        <span>فایل های نمونه کار</span><br>
                        <?php
                        $i = 0;
                        foreach ($concept_files as $file){
                            $file_ext = explode(".", $file)[1];
                            $file_name = explode(".", $file)[0];
                            $i++;
                            ?>
                            <a href="/files/dl/<?php echo str_replace(' ', '_', $file_name) . '/' . $file_ext;?>" target="_blank" class="fa-back font-size-13 py-2 px-1 w-25 radius-10 m-1 d-inline-block text-center custom-link" style="overflow: hidden;">
                                <?php
                                echo "file$i.$file_ext";
                                ?>
                            </a>
                            <?php
                        }
                        ?>
                    </p>
                    <?php
                }
                ?>
                <?php
                $pre_files = unserialize($presentation_files);
                if (!empty($pre_files)){
                    ?>
                    <p>
                        <span>فایل های ارائه</span><br>
                        <?php
                        $i = 0;
                        foreach ($pre_files as $file){
                            $file_ext = explode(".", $file)[1];
                            $file_name = explode(".", $file)[0];
                            $i++;
                            ?>
                            <a href="/files/dl/<?php echo str_replace(' ', '_', $file_name) . '/' . $file_ext;?>" target="_blank" class="fa-back font-size-13 py-2 px-1 w-25 radius-10 m-1 d-inline-block text-center custom-link" style="overflow: hidden;">
                                <?php
                                echo "file$i.$file_ext";
                                ?>
                            </a>
                            <?php
                        }
                        ?>
                    </p>
                    <?php
                }
                ?>
            </div>
            <a href="/judge/rate/<?php echo $id; ?>" class="brown-link brown-back text-center text-white w-100 btn py-2 mt-3 confirm-plan">ارزیابی طرح</a>
        </div>
        <div class="col-lg-9">
            <div class="fa-shadow radius-10 p-3 bg-white">
                <p class="title-color font-weight-bold border-bottom w-fit-content pb-1 px-1">اطلاعات صاحب طرح</p>
                <div class="fl-width d-inline-block w-50 mx-0 align-top">
                    <p class="title-color">نام و نام خانوادگی</p>
                    <p class="pr-2"><?php echo $owner_name; ?></p>
                </div>
                <div class="fl-width d-inline-block w-25 mx-0 align-top">
                    <p class="title-color">جنسیت</p>
                    <p class="pr-2"><?php echo $owner_gender; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top">
                    <p class="title-color">تاریخ تولد</p>
                    <p class="pr-2"><?php echo $owner_birth; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-35">
                    <p class="title-color">شماره تماس</p>
                    <p class="pr-2"><?php echo $owner_phone; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-35">
                    <p class="title-color">ایمیل</p>
                    <p class="pr-2"><?php echo $owner_email; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-25">
                    <p class="title-color">شهر محل سکونت</p>
                    <p class="pr-2"><?php echo $owner_city; ?></p>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">اطلاعات استارتاپ</p>
                <div class="fl-width d-inline-block mx-0 align-top w-20">
                    <p class="title-color">تعداد اعضای تیم</p>
                    <p class="pr-2"><?php echo $team_count; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-35">
                    <p class="title-color">میزان استفاده از امکانات مرکز نوآوری(به ساعت)</p>
                    <p class="pr-2"><?php echo $use_hours; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-40">
                    <p class="title-color">وضعیت فعلی استارتاپ</p>
                    <p class="pr-2"><?php echo $startup_level; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-35">
                    <p class="title-color">مدت زمان فعالیت استارتاپ(ماه)</p>
                    <p class="pr-2"><?php echo $startup_term; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-35">
                    <p class="title-color">زمینه فعالیت استارتاپ</p>
                    <p class="pr-2"><?php echo $startup_back; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-30">
                    <p class="title-color">سرمایه تقریبی مورد نیاز(تومان)</p>
                    <p class="pr-2"><?php echo $fund; ?></p>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">استارتاپ</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <p class="title-color">عنوان استارتاپ</p>
                    <p class="pr-2"><?php echo $idea_title; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <p class="title-color">شرح ایده</p>
                    <p class="pr-2"><?php echo $idea_exp; ?></p>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">مشتریان استارتاپ</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $customers; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">مدل درآمدی</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $income_model; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">مدل اقتصادی (درآمد ها و هزینه ها)</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $economic_model; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">رقبای داخلی و خارجی</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $rival; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">نوآوری و خلاقیت</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $innovation; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">مزیت رقابتی</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <?php echo $rival_advantage; ?>
                </div>
            </div>
            <div class="fa-shadow radius-10 p-3 bg-white my-3">
                <p class="title-color font-weight-bold w-fit-content pb-1 px-1 border-bottom">سابقه سرمایه گذاری و شتابدهی</p>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <p class="title-color">سابقه شتاب دهی استارتاپ</p>
                    <p class="pr-2"><?php echo $push_history; ?></p>
                </div>
                <div class="fl-width d-inline-block mx-0 align-top w-100">
                    <p class="title-color">سابقه سرمایه گذاری استارتاپ</p>
                    <p class="pr-2"><?php echo $investment_history; ?></p>
                </div>
            </div>
            <div class="fa-shadow bg-white radius-10 p-3 my-3 text-right" dir="rtl">
                <p class="font-weight-bold">اعضای تیم</p>
                <?php
                $members_image = unserialize($members_image);
                $members_name = unserialize($members_name);
                $members_certificate = unserialize($members_certificate);
                $members_age = unserialize($members_age);
                $members_birth = unserialize($members_birth);
                $members_history = unserialize($members_history);
                for ($i = 0; $i < $members_count; $i++){
                    ?>
                        <div class="fa-shadow radius-10 p-3 card plan-member my-3">
                            <img src="/uploads/<?php echo $members_image[$i]; ?>" alt="" class="member-image">
                            <div class="d-inline-block member-det-parent">
                                <span>نام و نام خانوادگی :</span>
                                <span class="title-color"><?php echo $members_name[$i]; ?></span>
                                <br>
                                <span>مدرک تحصیلی :</span>
                                <span class="title-color"><?php echo $members_certificate[$i]; ?></span>
                                <br>
                                <span>تاریخ تولد :</span>
                                <span class="title-color"><?php echo $members_birth[$i]; ?></span>
                            </div>
                            <p class="my-2">سوابق</p>
                            <p class="text-justify title-color" style="height: 96px; overflow: hidden;"><?php echo $members_history[$i]; ?></p>
                        </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="add-plan-back" style="display:none;"></div>
<script src="/Views/js/confirm-plan.js?version=<?php echo rand(); ?>"></script>