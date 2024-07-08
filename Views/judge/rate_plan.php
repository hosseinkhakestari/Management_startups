<form action="" method="post" class="padding-x-50 mtop-80 text-right">
    <div class="row">
        <?php
        $i = 1;
        foreach (judge_ques as $question){
            $ans = "ans" . $i;
            $rate = "rate" . $i;
            ?>
            <p class="col-12">
                <?php
                echo $question;
                ?>
            </p>
            <div class="col-lg-9 form-group">
                <textarea name="ans<?php echo $i; ?>" id="" class="form-control w-100 none-resize h-150"><?php echo $$ans; ?></textarea>
            </div>
            <div class="col-lg-2 form-group">
                <select name="rate<?php echo $i; ?>" id="" class="bg-white w-100 form-control">
                    <option value="" disabled selected hidden>نمره</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <script>
                    $("select[name=<?php echo 'rate' . $i;?>]").val("<?php echo $$rate; ?>");
                </script>
            </div>
            <?php
            $i++;
        }
        ?>
        <p class="col-12">
            جمع بندی خود را درباره این طرح ذکر نمایید
        </p>
        <div class="col-12 form-group">
            <textarea name="analyz" class="form-control w-100 none-resize h-250"><?php echo $analyz; ?></textarea>
        </div>
        <div class="col-12 form-group text-left">
            <input type="submit" name="rate_plan" class="brown-back text-white btn-200 btn py-2" value="ثبت و ادامه">
        </div>
    </div>
</form>
<?php require_once ROOT . "Views/public/alert_message.php"; ?>