<div class="container-fluid padding-x-50 mtop-80">
    <div class="row px-3">
        <div class="col-lg-6 fa-shadow mx-auto">
            <form action="" method="post">
                <table class="w-100 text-center">
                    <thead class="fixed">
                    <tr>
                        <td  class="py-3 font-weight-bold w-50" >نام دسته</td>
                        <td class="py-3 font-weight-bold w-50">مبلغ به ازای هر دسته</td>
                    </tr>
                    </thead>
                </table>
                <div class="w-100" style="max-height: 360px; overflow: scroll;">
                    <table class="w-100 text-center">
                        <tbody class="font-size-13 plans_tbody">
                        <?php
                        foreach ($cats as $name => $financial){
                            if ($financial == 0){
                                $financial = "";
                            }
                            ?>
                            <tr class="border-bottom plans_tr">
                                <td style="padding-top: 25px; padding-bottom: 5px;" class="w-50"><?php echo $name; ?></td>
                                <td style="padding-top: 25px; padding-bottom: 5px;" class="w-50">
                                    <input type="text" name="cat<?php echo $name; ?>" placeholder="مبلغ" class="form-control mx-auto py-1 fa-back none-spinner amount_input text-center" id="amount_input" style="width: 100px;" value="<?php echo convert_amount($financial); ?>">
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <table class="w-100 text-center">
                    <tbody>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" name="submit_cats_financial" value="ذخیره" class="btn btn-200 fa-back my-3 fa-shadow">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
