<div class="container-fluid padding-x-50 mtop-80">
        <div class="row fa-shadow bg-white radius-10 p-4 text-right">
            <div class="col-12">گزارش از طرح ها</div>
            <div class="col-lg-2 my-3">نام طرح(ها) : </div>
            <div class="col-lg-4 my-3">
                <select class="form-control select2 select2pname plans_name" name="plans_name" multiple="multiple">
                    <?php
                    foreach ($plans as $plan){
                        $name = $plan["idea_title"];
                        echo "<option value='$name' class='text-right'>$name</option>";
                    }
                    ?>
                </select>
<!--                <textarea name="" id="" rows="4" class="w-100 form-control none-resize plans_name" placeholder="طرح ۱ ، طرح ۲ ..."></textarea>-->
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">تاریخ : </div>
            <div class="col-lg-2 date_parent my-3">
                <i class="far fa-calendar-alt"></i>
                <input type="text" class="form-control date_from" placeholder="از تاریخ" required name="" autocomplete="off" value="">
            </div>
            <div class="col-lg-2 my-3 date_parent">
                <i class="far fa-calendar-alt"></i>
                <input type="text" class="form-control date_to" placeholder="تا تاریخ" required name="" autocomplete="off" value="">
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">نمره : </div>
            <div class="col-lg-2 my-3">
                <input type="number" min="0" max="10" class="form-control none-spinner rate_from" placeholder="از نمره">
            </div>
            <div class="col-lg-2 my-3">
                <input type="number" min="0" max="10" class="form-control none-spinner rate_to" placeholder="تا نمره">
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">وضعیت طرح : </div>
            <div class="col-lg-2 col-6 my-3">
                <input type="checkbox" class="status" value="rated">
                <span>ارزیابی شده</span>
            </div>
            <div class="col-lg-2 col-6 my-3">
                <input type="checkbox" class="status" value="not_rated">
                <span>ارزیابی نشده</span>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">دسته بندی : </div>
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
            <div class="col-lg-2 my-3">شهر - استان : </div>
            <div class="col-lg-4 my-3">
                <select class="form-control select2 select2city cities" name="state" multiple="multiple">
                    <?php
                    foreach (cities as $city){
                        echo "<option value='$city' class='text-right'>$city</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">سرمایه مورد نیاز : </div>
            <div class="col-lg-2 mt-3">
                <input type="checkbox" class="fund" value="<= 100000000">
                <span>کمتر از ۱۰۰ میلیون</span>
            </div>
            <div class="col-lg-2 mt-3">
                <input type="checkbox" class="fund" value=">= 100000000 && fund <= 400000000">
                <span>بین ۱۰۰ تا ۴۰۰ میلیون</span>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-2 my-3">
                <input type="checkbox" class="fund" value=">= 400000000 && fund <= 700000000">
                <span>بین ۴۰۰ تا ۷۰۰ میلیون</span>
            </div>
            <div class="col-lg-2 my-3">
                <input type="checkbox" class="fund" value=">= 700000000">
                <span>بیشتر از ۷۰۰ میلیون</span>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-2 my-3">مرحله اجرایی : </div>
            <div class="col-lg-2 mt-3">
                <input type="checkbox" class="level" value="ایده و طرح کسب و کار">
                <span>ایده و طرح کسب و کار</span>
            </div>
            <div class="col-lg-2 mt-3">
                <input type="checkbox" class="level" value="در حال اجرا">
                <span>در حال اجرا</span>
            </div>
            <div class="col-lg-6 mt-3">
                <input type="checkbox" class="level" value="دارای نمونه اولیه">
                <span>دارای نمونه اولیه(محصول)</span>
            </div>
            <div class="col-lg-10 text-left my-3">
                <button class="btn fa-back fa-shadow btn-200 report_btn" type="button">گزارش</button>
            </div>
        </div>
    <div class="row fa-shadow bg-white radius-10 p-4 text-right mt-4" style="overflow: scroll;">
        <table class="table text-center plans_table">
            <thead>
                <tr>
                    <th class="border-0">نام طرح</th>
                    <th class="border-0">نام ارزیاب(ها)</th>
                    <th class="border-0">مرحله اجرایی</th>
                    <th class="border-0">دسته</th>
                    <th class="border-0">سرمایه مورد نیاز</th>
                    <th class="border-0">تاریخ ثبت</th>
                    <th class="border-0">نمره</th>
                    <th class="border-0">شهر/استان</th>
                    <th class="border-0">وضعیت</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($plans as $plan){
                ?>
                <tr>
                    <td><?php echo $plan["idea_title"]; ?></td>
                    <td>
                        <?php
                        if ($plan["judges"] !== null){
                            $plan_judges = unserialize($plan["judges"]);
                            $names = array();
                            foreach ($plan_judges as $judge){
                                array_push($names, $judges[$judge]);
                            }
                            echo implode(" , ", $names);
                        }
                        ?>
                    </td>
                    <td><?php echo $plan["idea_level"]; ?></td>
                    <td>
                        <?php
                        if (!empty($plan["startup_back_edit"])){
                            echo implode(" , ", unserialize($plan["startup_back_edit"]));
                        }else{
                            echo $plan["startup_back"];
                        }
                        ?>
                    </td>
                    <td><?php echo convert_amount($plan["fund"]); ?></td>
                    <td><?php echo convert_datetime($plan["time"]); ?></td>
                    <td><?php echo $plan["rate"]; ?></td>
                    <td><?php echo $plan["owner_city"]; ?></td>
                    <td>
                        <?php
                        $status = $plan["status"];
                        $final_status = $plan["final_status"];
                        if ($status === null){
                            echo "نا مشخص";
                        }elseif ($status == "sended"){
                            echo "در انتظار ارزیابی";
                        }elseif ($status == "rejected"){
                            echo "رد شده";
                        }elseif ($status == "rated" && $final_status == "passed"){
                            echo "ارزیابی شده - قبول";
                        }elseif ($status == "rated" && $final_status == "rejected"){
                            echo "ارزیابی شده - رد";
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script src="/Views/js/plans_report.js?version=<?php echo rand(); ?>"></script>
