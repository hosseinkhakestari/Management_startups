<div class="container-fluid padding-x-50 mtop-80">
    <div class="row fa-shadow bg-white radius-10 p-4 text-right">
        <div class="col-12">گزارش از ارزیاب ها</div>
        <div class="col-lg-2 my-3">نام ارزیاب(ها) : </div>
        <div class="col-lg-4 my-3">
            <select class="form-control select2 select2jname judges_name" name="judges_name" multiple="multiple">
                <?php
                foreach ($judges as $judge){
                    $name = $judge["judge_name"];
                    echo "<option value='$name' class='text-right'>$name</option>";
                }
                ?>
            </select>
<!--            <textarea name="" id="" rows="4" class="w-100 form-control none-resize judges_name" placeholder="ارزیاب ۱ ، ارزیاب ۲ ..."></textarea>-->
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-2 my-3">دستمزد : </div>
        <div class="col-lg-2 my-3">
            <input type="text" class="form-control amount_input financial_from" id="amount_input" placeholder="از مبلغ">
        </div>
        <div class="col-lg-2 my-3">
            <input type="text" class="none-spinner form-control amount_input financial_to" id="amount_input" placeholder="تا مبلغ">
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-2 my-3">تاریخ عضویت : </div>
        <div class="col-lg-2 my-3 date_parent">
            <i class="far fa-calendar-alt"></i>
            <input type="text" class="form-control date_from" placeholder="از تاریخ">
        </div>
        <div class="col-lg-2 my-3 date_parent">
            <i class="far fa-calendar-alt"></i>
            <input type="text" class="form-control date_to" placeholder="تا تاریخ">
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-2 my-3">سن : </div>
        <div class="col-lg-2 my-3">
            <input type="number" class="form-control none-spinner age_from" placeholder="از">
        </div>
        <div class="col-lg-2 my-3">
            <input type="number" class="form-control none-spinner age_to" placeholder="تا">
        </div>
        <div class="col-lg-6"></div>
        <div class="col-lg-2">حوزه فعالیت :‌ </div>
        <?php
            $i = 0;
            foreach (startup_backs as $back){
                if ($i%4 == 0 && $i !== 0){
                    echo "<div class='col-lg-2'></div>";
                    echo "<div class='col-lg-2'></div>";
                }
                echo "<div class='col-lg-2 col-6 my-3'><input type='checkbox' value='$back' class='cats'><span> $back</span></div>";
                $i++;
            }
            if ($i%4 !== 0){
                while ($i%4 !== 0){
                    echo "<div class='col-lg-2'></div>";
                    $i++;
                }
                echo "<div class='col-lg-2'></div>";
            }
            ?>
        <div class="col-lg-10 text-left my-3">
            <button class="btn fa-back fa-shadow btn-200 report_btn" type="button">گزارش</button>
        </div>
    </div>
    <div class="row fa-shadow bg-white radius-10 p-4 text-right mt-4" style="overflow: scroll;">
        <table class="table text-center judges_table">
            <thead>
            <tr>
                <th class="border-0">نام ارزیاب</th>
                <th class="border-0">تعداد طرح ها</th>
                <th class="border-0">تعداد طرح های ارزیابی شده</th>
                <th class="border-0">دسته</th>
                <th class="border-0">کل دریافتی</th>
                <th class="border-0">تاریخ عضویت</th>
                <th class="border-0">سن</th>
                <th class="border-0"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($judges as $judge){
                echo "<tr>";
                echo "<td>" . $judge["judge_name"] . "</td>";
                echo "<td>" . $judge["plans_count"] . "</td>";
                echo "<td>" . $judge["rated_plans"] . "</td>";
                echo "<td>" . $judge["category"] . "</td>";
                echo "<td>" . $judge["financial"] . "</td>";
                echo "<td>" . convert_datetime($judge["time"]) . "</td>";
                echo "<td>" . $judge["age"] . "</td>";
                echo "<td><a class='btn brown-back text-white reset_pass_btn' href='/admin/reset_judge_pass/".  $judge["id"] ."'>ریست پسورد</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script src="/Views/js/judges_report.js?version=<?php echo rand(); ?>"></script>