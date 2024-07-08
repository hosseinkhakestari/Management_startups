<div class="container-fluid padding-x-50 mtop-80">
    <div class="row fa-shadow bg-white radius-10 p-4 text-right" style="overflow: scroll;">
        <div class="col-12">
            طرح ها ارزیابی شده توسط <?php echo $judge["judge_name"]; ?>
        </div>
        <?php
        if (count($plans) > 0){
            ?>
            <table class="table table-bordered my-3 table text-center">
                <?php
                foreach ($plans as $plan){
                    ?>
                    <thead class="thead-light">
                        <tr>
                            <th class="w-25">نام طرح</th>
                            <th class="w-25">امتیاز</th>
                            <th class="w-25">هزینه</th>
                            <th class="w-25">تاریخ ارزیابی</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fa-bak"><?php echo $plan["plan_name"]; ?></td>
                            <td><?php echo $plan["rate"]; ?></td>
                            <td><?php echo $plan["financial"]; ?></td>
                            <td dir="ltr"><?php echo $plan["date"] . " - " . $plan["time"]; ?></td>
                        </tr>
                        <tr>
                            <td>سوالات</td>
                            <td colspan="2">جواب</td>
                            <td>امتیاز</td>
                        </tr>
                        <?php
                        foreach ($plan["answers"] as $ques => $answer){
                            echo "<tr>" .
                                "<td>$ques</td>" .
                                "<td colspan='2'>" . $answer["ans"] . "</td>" .
                                "<td>". $answer["rate"] ."</td>" .
                                "</tr>";
                        }
                        ?>
                    </tbody>
                    <?php
                }
                ?>
            </table>
            <?php
        }else{
            echo "<div class='col-12 my-3'>این ارزیاب تا کنون ارزیابی انجام نداده است.</div>";
        }
        ?>
    </div>
</div>