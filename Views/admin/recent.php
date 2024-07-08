<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/2/20
 * Time: 5:26 AM
 */
?>
<div class="container-fluid padding-x-50 mtop-80">
    <div class="row">
        <?php require_once "side.php"; ?>
        <div class="col-lg-9 plans-parent">
            <?php
            require_once "top_filters.php";
            foreach ($plans as $plan){
                $link = "view/" . $plan["id"];
                if (isset($sended_page)){
                    $link = "#";
                }
                ?>
                <a href="<?php echo $link; ?>" style="text-decoration: none !important; color: inherit; z-index: 1;">
                    <div class="fa-shadow radius-10 bg-white p-3 text-right my-3 plans-div" style="position: relative;">
                        <p>
                            <span class="font-weight-bold"><?php echo $plan['idea_title']; ?></span>
                            <span class="font-size-13">(<?php echo $plan['startup_back']; ?>)</span>
                        </p>
                        <p class="font-size-13">
                            تاریخ ثبت :
                            <?php
                                echo convert_datetime($plan['time']);
                            ?>
                        </p>
                        <p class="font-size-13" style="max-height: 38px; overflow: hidden;">
                            <?php echo $plan['idea_exp']; ?>
                        </p>
                        <?php
                        if (isset($sended_page)){
                            foreach ($plan["judges"] as $judge){
                                $name = $judge["name"];
                                $rated = $judge["rated"];
                                $color = "inherit";
                                if ($rated){
                                    $color = "lightgreen";
                                }
                                echo "<span style='color: $color;' class='font-size-13 border m-1 px-1 radius-10'> $name </span>";
                            }
                            echo "<br>";
                            ?>
                            <div class="mt-3 text-left">
                                <a id="<?php echo $plan['id']; ?>" class="radius-10 btn fa-back fa-shadow d-inline-block mr-2 text-dark edit_judges_btn">افزودن / حذف ارزیاب</a>
                            </div>
                            <?php
                        }elseif (isset($rejected_page)){
                            ?>
                            <div class="add-member-form bg-white radius-10 p-0 text-right" style="display: none; z-index: 2;" onclick="return false;">
                                <p class="fa-back w-100 m-0 text-center p-3 intro-p head-p">
                                    دلیل عدم پذیرش طرح
                                    <button class="close-form-button"><i class="fa fa-plus"></i></button>
                                </p>
                                <div class="pt-3 p-4 add-form-content">
                                    <?php echo nl2br($plan["expl"]); ?>
                                </div>
                                <p class="text-center fa-back p-2 m-0 head-p">
                                    <button class="brown-back cursor-p text-white py-2 btn btn-200" type="button" style="opacity: 0;">ثبت و ادامه</button>
                                </p>
                            </div>
                            <div class="mt-3 text-left">
                                <button class="radius-10 btn fa-back fa-shadow d-inline-block view-reason-btn">دلایل عدم پذیرش</button>
                            </div>
                            <?php
                        }
                        if (isset($rated_page)){
                            $rate = $plan["rate"];
                            echo "<span class='plan-rate'> $rate </span>";
                        }
                        ?>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="add-plan-back" style="display:none;"></div>
<?php
if (isset($sended_page)){
    ?>
    <div class="add-member-form bg-white radius-10 p-0 text-right edit-judges-form" style="display: none;">
        <p class="fa-back w-100 m-0 text-center p-3 intro-p head-p">
            افزودن / حذف ارزیاب
            <button class="close-form-button"><i class="fa fa-plus"></i></button>
        </p>
        <div class="pt-3 px-4 row pb-3 add-form-content">

            <?php
            foreach ($all_judges as $judge){
                ?>
                <div class="col-lg-6 text-center filter-items2">
                    <p class="wi-200 text-right mx-auto checkbox-p2">
                        <?php echo $judge["judge_name"]; ?>
                        <input type="checkbox" value="<?php echo $judge['id']; ?>" class="float-left all_judges mt-2">
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
        <p class="text-center fa-back p-2 m-0 head-p">
            <button class="brown-back cursor-p text-white py-2 btn btn-200 confirm-edit-judges-btn" type="button">ثبت و ادامه</button>
        </p>
    </div>
    <?php
}
?>
<script src="/Views/js/confirm-plan.js?version=<?php echo rand(); ?>"></script>