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
        <?php require_once ROOT . "Views/admin/side.php"; ?>
        <div class="col-lg-9 plans-parent">
            <?php
            require_once ROOT . "Views/admin/top_filters.php";
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
                        <span class="plan-rate"><?php echo $plan["rate"]; ?></span>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="add-plan-back" style="display:none;"></div>
<script src="/Views/js/confirm-plan.js?version=<?php echo rand(); ?>"></script>