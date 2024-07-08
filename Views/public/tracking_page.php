<div class="container padding-x-50">
    <div class="row">
        <p class="font-weight-bold text-center my-4 col-12">خلاصه وضعیت طرح</p>
        <div class="col-12 bg-white px-3 py-4 radius-10 text-right">
            <p>
                نام طرح :
                <?php echo $name; ?>
            </p>
            <p class="my-4 py-4">
                وضعیت :
                <span style=" background: <?php echo $status_color; ?>;" class="radius-10 px-2 text-white"><?php echo $status; ?></span>
            </p>
            <?php
            if ($expl !== NULL){
                ?>
                <p>توضیحات : </p>
                <p class="title-color font-size-13 text-justify"><?php echo $expl; ?></p>
                <?php
            }
            ?>
        </div>
    </div>
</div>