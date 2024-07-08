<div class="col-lg-3 text-right">
    <div class="bg-white fa-shadow p-2 mb-3">
        <p class="w-100 m-0">
            دسته بندی
            <i class="fas fa-angle-down toggle-filters float-left" style="margin-top: 6px;"></i>
        </p>
        <div class="font-size-13 filter-items" style="display: none;">
            <hr style="margin-right: -1em; margin-left: -1em;">
            <?php
            foreach (startup_backs as $back){
                echo "<p class='checkbox-p'>";
                echo "<input type='checkbox' class='startup_back' value='$back' style='vertical-align: middle !important;'> $back";
                echo "</p>";
            }
            ?>
        </div>
    </div>
    <?php
    if (isset($judges_financial_page)){
        echo "</div>";
        echo '<script src="/Views/js/filter-judges-financial.js?version= ' . rand() . '"></script>';
        return;
    }
    if (isset($judge_page)){
        ?>
        <div class="bg-white fa-shadow p-2 my-3">
            <p class="w-100 m-0">
                وضعیت طرح
                <i class="fas fa-angle-down toggle-filters float-left" style="margin-top: 6px;"></i>
            </p>
            <div class="font-size-13 filter-items" style="display: none;">
                <hr style="margin-right: -1em; margin-left: -1em;">
                <p class="checkbox-p">
                    <input type="checkbox" class="rated_status" value="1"> ارزیابی شده
                </p>
                <p class="checkbox-p">
                    <input type="checkbox" class="rated_status" value="0"> ارزیابی نشده
                </p>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="bg-white fa-shadow p-2 mb-3">
        <p class="w-100 m-0">
            مرحله اجرایی طرح
            <i class="fas fa-angle-down toggle-filters float-left" style="margin-top: 6px;"></i>
        </p>
        <div class="font-size-13 filter-items" style="display: none;">
            <hr style="margin-right: -1em; margin-left: -1em;">
            <?php
            foreach (idea_levels as $level){
                echo "<p class='checkbox-p'>";
                echo "<input type='checkbox' class='idea_level' value='$level' style='vertical-align: middle !important;'> $level";
                echo "</p>";
            }
            ?>
        </div>
    </div>
    <div class="bg-white fa-shadow p-2 my-3">
        <p class="w-100 m-0">
            سرمایه مورد نیاز
            <i class="fas fa-angle-down toggle-filters float-left" style="margin-top: 6px;"></i>
        </p>
        <div class="font-size-13 filter-items" style="display: none;">
            <hr style="margin-right: -1em; margin-left: -1em;">
            <p class='checkbox-p'>
                <input type="checkbox" class="fund" value="100" style="vertical-align: middle !important;"> کمتر از ۱۰۰ میلیون
            </p>
            <p class='checkbox-p'>
                <input type="checkbox" class="fund" value="100-400" style="vertical-align: middle !important;"> بین ۱۰۰ تا ۴۰۰ میلیون
            </p>
            <p class='checkbox-p'>
                <input type="checkbox" class="fund" value="400-700" style="vertical-align: middle !important;"> بین ۴۰۰ تا ۷۰۰ میلیون
            </p>
            <p class='checkbox-p'>
                <input type="checkbox" class="fund" value="700" style="vertical-align: middle !important;"> بیشتر از ۷۰۰ میلیون
            </p>
        </div>
    </div>
    <div class="bg-white fa-shadow p-2 my-3">
        <p class="w-100 m-0">
            شهر و استان
            <i class="fas fa-angle-down toggle-filters float-left" style="margin-top: 6px;"></i>
        </p>
        <div class="font-size-13 filter-items" style="display: none;">
            <hr style="margin-right: -1em; margin-left: -1em;">
            <?php
            foreach (cities as $city){
                echo "<p class='checkbox-p'>";
                echo "<input type='checkbox' class='city_filter' value='$city' style='vertical-align: middle !important;'> $city";
                echo "</p>";
            }
            ?>
        </div>
    </div>
</div>
<script src="/Views/js/filter-plans.js?version=<?php echo rand();?>"></script>
