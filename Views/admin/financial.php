<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/7/20
 * Time: 5:01 AM
 */
?>
<div class="container-fluid padding-x-50 mtop-80">
    <div class="row">
        <?php require_once "side.php"; ?>
        <div class="col-lg-6 plans-parent">
            <?php
            require_once "top_filters.php";
            ?>
            <div class="w-100 fa-shadow bg-white radius-10 mt-3 px-3">
                <form action="" method="post">
                    <table class="w-100 text-center">
                        <thead class="fixed">
                        <tr>
                            <td  class="py-3 font-weight-bold w-50">نام طرح</td>
                            <td  class="py-3 font-weight-bold w-50">مبلغ</td>
                        </tr>
                        </thead>
                    </table>
                    <div class="w-100" style="max-height: 360px; overflow: scroll;">
                        <table class="w-100 text-center">
                            <tbody class="font-size-13 plans_tbody">
                            <?php
                            foreach ($plans as $plan){
                                if ($plan["financial"] == 0){
                                    $plan["financial"] = "";
                                }
                                ?>
                                <tr class="border-bottom plans_tr">
                                    <td class="w-50" style="padding-top: 25px; padding-bottom: 5px;"><?php echo $plan["idea_title"]; ?></td>
                                    <td class="w-50" style="padding-top: 25px; padding-bottom: 5px;">
                                        <input type="text" name="<?php echo "plan" . $plan['id']; ?>" placeholder="مبلغ" class="form-control mx-auto py-1 fa-back none-spinner amount_input text-center" id="amount_input" style="width: 100px;" value="<?php echo convert_amount($plan['financial']); ?>">
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
                                <input type="submit" name="submit_plans_financial" value="ذخیره" class="btn btn-200 fa-back my-3 fa-shadow">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/Views/js/add-plan-member.js?version=<?php echo rand(); ?>"></script>