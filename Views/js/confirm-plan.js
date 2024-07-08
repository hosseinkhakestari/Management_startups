function confirm_plan(){
    var cats = $(".confirm-cats:checked");
    var cats_name = [];
    for (var i = 0; i < cats.length; i++){
        cats_name.push(cats.eq(i).val());
    }
    var judges = $(".plan-judges:checked");
    var judges_id = [];
    for (var i = 0; i<judges.length; i++){
       judges_id.push(judges.eq(i).val());
    }
    $.post(window.location.href,
        {
            cats: cats_name,
            judges : judges_id,
            confirm_plan : true
        },
        function(data, status){
            if (status == "success" && data == "OK"){
                window.location.href = "/admin/recent";
            }
        });
}

function reject_plan(){
    var reason = $(".reject-reason").val();
    if (reason.trim() == ""){
        $.alert({
            title: '',
            content: '<p style="text-align: right">دلایل رد شدن طرح را وارد کنید</p>',
            buttons: {
                باشه:function () {

                }
            }
        });
    }else{
        $.post(window.location.href,
            {
                reason : reason,
                reject_plan : true
            },
            function(data, status){
                console.log(data);
                if (status == "success" && data == "OK"){
                    window.location.href = "/admin/recent";
                }
            });
    }
}

function final_rate(){
    var status = $("input.final-status:checked");
    if (status.length == 0){
        $.alert({
            title: '',
            content: '<p style="text-align: right">وضعیت طرح را انتخاب کنید</p>',
            buttons: {
                باشه:function () {

                }
            }
        });
        return;
    }
    status = status.eq(0).val();
    var expl = $(".final-expl").val();
    if (expl.trim() == ""){
        $.alert({
            title: '',
            content: '<p style="text-align: right;">توضیحات را وارد کنید</p>',
            buttons: {
                باشه:function () {

                }
            }
        });
        return;
    }
    expl = expl.trim();
    $.post(window.location.href,
        {
            final_status : status,
            expl : expl,
            final_rate : true
        },
        function(data, status){
            console.log(data);
            if (status == "success" && data == "OK"){
                window.location.href = "/admin/rated";
            }
        });
}

function edit_judges(plan){
        var selected_judges = $("input.all_judges:checked");
        var ids = [];
        for (var i = 0; i < selected_judges.length; i++){
            ids.push(selected_judges.eq(i).val());
        }
        if (ids.length == 0){
            return;
        }
        $.post("/admin/edit_plan_judges/"+plan,
            {
                ids : ids
            },
            function(data, status){
            console.log(data);
                if (status == "success" && data == "OK"){
                    window.location.reload();
                }else{
                    $(".add-plan-back").fadeOut();
                    $(".edit-judges-form").fadeOut();
                }
            });
}
$(document).ready(function () {
    $(".confirm-plan").click(function () {
        $(".add-plan-back").fadeIn();
        $(".plan-cat-form").fadeIn();
        $("body").css("overflow", "hidden");
        $("nav").css("z-index", 0);
    });
    $(".close-form-button").click(function () {
        $(this).parents().find("div.add-member-form").fadeOut();
        $(".add-plan-back").fadeOut();
        $("body").css("overflow", "scroll");
        $("nav").css("z-index", 2);
    });
    $(".accept-cats-btn").click(function () {
        $(".plan-cat-form").fadeOut();
        $(".plan-judge-form").fadeIn();
    });
    $(".accept-judges-btn").click(function () {
        var checked = $(".plan-judge-form").find("input:checked");
        for (var i = 0; i < checked.length; i++){
            $(".delete-judge-form").find(":checkbox[value=" + checked.eq(i).val() +"]").prop("checked", true);
        }
        $(".plan-judge-form").fadeOut();
        $(".delete-judge-form").fadeIn();
    });
    $(".confirm-plan-btn").click(function () {
        confirm_plan();
    });
    $(".reject-plan").click(function () {
        $(".add-plan-back").fadeIn();
        $(".reject-form").fadeIn();
        $("body").css("overflow", "hidden");
        $("nav").css("z-index", 0);
    });
    $(".reject-plan-btn").click(function () {
        reject_plan();
    });
    $(".view-reason-btn").click(function () {
        $(this).parent().siblings(".add-member-form").fadeIn();
        $(".add-plan-back").fadeIn();
        $("body").css("overflow", "hidden");
        $("nav").css("z-index", 0);
        return false;
    });
    $(".final-confirm").click(function () {
        $(".add-plan-back").fadeIn();
        $(".final-form").fadeIn();
    });
    $(".final-rate-btn").click(function () {
        final_rate();
    });
//    edit judges on sended page
    $(".edit_judges_btn").click(function () {
        edit_jds(this);
    });
});