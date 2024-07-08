function filter_plans(){
    var href = window.location.href;
    var plans_status = "";
    var address = "/admin/filter_plans";
    if (href.indexOf("recent")>-1){
        plans_status = "";
    }
    if (href.indexOf("sended")>-1){
        plans_status = "sended";
    }
    if (href.indexOf("rejected")>-1){
        plans_status = "rejected";
    }
    if (href.indexOf("judge/plans")>-1){
        plans_status = "sended";
        address = "/judge/filter_plans";
    }
    if (href.indexOf("rated")>-1){
        plans_status = "rated";
    }
    if (href.indexOf("plans_financial")>-1){
        plans_status = "financial";
    }
    var startup_back = $("input.startup_back:checked");
    var back_filters = "";
    for (var i = 0; i < startup_back.length; i++){
        back_filters += "'" + startup_back.eq(i).val() + "'" + ",";
    }
    back_filters = back_filters.substring(0, back_filters.length - 1);
    var idea_levels = $("input.idea_level:checked");
    var level_filters = "";
    for (var i = 0; i < idea_levels.length; i++){
        level_filters += "'" + idea_levels.eq(i).val() + "'" + ",";
    }
    level_filters = level_filters.substring(0, level_filters.length - 1);
    var fund = $("input.fund:checked");
    var fund_filter = fund.eq(0).val();
    if (!fund_filter){
        fund_filter = "";
    }
    var cities = $("input.city_filter:checked");
    var cities_filter = "";
    for (var i = 0; i < cities.length; i++){
        cities_filter += "'" + cities.eq(i).val() + "'" + ",";
    }
    cities_filter = cities_filter.substring(0, cities_filter.length - 1);
    var rated = $(".rated_status:checked");
    if (rated.length > 0){
        rated = rated.eq(0).val();
    } else{
        rated = "";
    }
    var order = $("#plans_order").val();
    var searched = $(".search-plans").val();
    $.post(address,
        {
            plans_status : plans_status,
            back_filters: back_filters,
            level_filters : level_filters,
            fund_filter : fund_filter,
            cities_filter : cities_filter,
            order : order,
            rated : rated,
            searched : searched
        },
        function(data, status){
            var href = window.location.href;
            if (data !== "404" && data !== "" && status == "success"){
                var plans = JSON.parse(data);
                if (href.indexOf("plans_financial") > 0){
                    $(".plans_tr").fadeOut();
                    $(".loader").fadeIn();
                    $(".loader-back").fadeIn();
                    for(var i = 0; i < plans.length; i++) {
                        var financial = convert_amount(plans[i]["financial"]);
                        if (financial == 0){
                            financial = "";
                        }
                        var id = plans[i]["id"];
                        var tr = "<tr class='border-bottom plans_tr'>" +
                            "<td class='w-50' style='padding-top: 25px; padding-bottom: 5px;'>" + plans[i]["owner_name"] + "</td>" +
                            "<td class='w-50' style='padding-top: 25px; padding-bottom: 5px;'>" +
                            "<input type='text' name='plan" + id + "' placeholder='مبلغ' class='form-control mx-auto py-1 fa-back none-spinner amount_input text-center' id='amount_input' style='width: 100px;' value='" + financial + "'>" +
                            "</td>" +
                            "</tr>";
                        $(".plans_tbody").append(tr);
                    }
                    $(".plans_tbody").find("input#amount_input").on("input", function () {
                        add_semi(this);
                    });
                    $(".loader").fadeOut();
                    $(".loader-back").fadeOut();
                }else{
                    $(".plans-div").fadeOut();
                    $(".loader").fadeIn();
                    $(".loader-back").fadeIn();
                    setTimeout(function () {
                        $(".plans-div").remove();
                        for(var i = 0; i < plans.length; i++){
                            var link = "view/" + plans[i]["id"];
                            if (plans_status == "sended" && address == "/admin/filter_plans"){
                                link = "#";
                            }
                            var plan_sec = '<a href="'+ link +'" style="text-decoration: none !important; color: inherit;"><div class="fa-shadow radius-10 bg-white p-3 text-right my-3 plans-div" style="display: none; position: relative;">\n' +
                                '                    <p>\n' +
                                '                        <span class="font-weight-bold">'+ plans[i]['owner_name'] +'</span>\n' +
                                '                        <span class="font-size-13">('+ plans[i]['startup_back'] +')</span>\n' +
                                '                    </p>\n' +
                                '                    <p class="font-size-13">\n' +
                                '                        تاریخ ثبت :\n' + plans[i]['date'] +
                                '                    </p>\n' +
                                '                    <p class="font-size-13" style="max-height: 38px; overflow: hidden;">\n' + plans[i]['idea_exp'] +
                                '                    </p>';
                            if (plans_status == "sended" && address == "/admin/filter_plans"){
                                for (var j = 0; j < plans[i]["judges"].length; j++){
                                    var color = "inherit";
                                    if (plans[i]["judges"][j]["rated"]){
                                        color = "lightgreen";
                                    }
                                    plan_sec += " <span style='color: " + color + "' class='font-size-13 border m-1 px-1 radius-10'>" + plans[i]["judges"][j]["name"] + "</span> ";
                                }
                                plan_sec += '<div class="mt-3 text-left">\n' +
                                    '<button id="'+ plans[i]["id"] +'" class="radius-10 btn fa-back fa-shadow d-inline-block edit_judges_btn">افزودن / حذف ارزیاب</button>\n' +
                                    '</div>';
                            }else if(plans_status == "rejected"){
                                plan_sec += '<div class="mt-3 text-left">\n' +
                                    '             <button class="radius-10 btn fa-back fa-shadow d-inline-block">دلایل عدم پذیرش</button>\n' +
                                    '        </div>';
                            }else if ((plans_status == "sended" && address == "/judge/filter_plans") || plans_status == "rated"){
                                plan_sec += "<sapn class='plan-rate'>" + plans[i]["rate"] + "</sapn>";
                            }
                            plan_sec += '</div></a>';
                            $(".plans-parent").append(plan_sec);
                            $(".edit_judges_btn").click(function () {
                                edit_jds(this);
                            });
                        }
                        $(".plans-div").fadeIn();
                        $(".loader").fadeOut();
                        $(".loader-back").fadeOut();
                        if (plans.length < 1){
                            $.alert({
                                title: '',
                                content: '<p style="text-align: right">طرحی در این دسته(ها) وجود ندارد.</p>',
                                buttons: {
                                    باشه:function () {

                                    }
                                }
                            });
                        }
                    },1000);
                }
            }
        }
        );
}
$(document).ready(function () {
    //    uncheck another funds
    $("input.fund").click(function () {
        $(this).parent().siblings("p").find("input").prop("checked", false);
    });
    $("input.rated_status").click(function () {
        $(this).parent().siblings("p").find("input").prop("checked", false);
    });
    //slide down and up filters
    $(".toggle-filters").parent().click(function () {
        $(this).siblings(".filter-items").slideToggle();
        var i = $(this).find("i");
        if (i.hasClass("fa-angle-down")){
            i
                .removeClass("fa-angle-down")
                .addClass("fa-angle-up");
        }else{
            i
                .removeClass("fa-angle-up")
                .addClass("fa-angle-down");
        }
    });
//    filter
//     $(".filter-items").find("input").click(function () {
//         // filter_plans();
//         $(this).parent().click();
//     });
//     $(".checkbox-p").click(function () {
//         var input = $(this).find("input");
//         if (input.prop("checked")){
//             input.prop("checked", false);
//         } else{
//             input.prop("checked", true);
//         }
//         filter_plans();
//     });
    $("#plans_order").change(function () {
        filter_plans();
    });
    $(".search-plans").on("input", function () {
        for (var i = 1; i < 99999; i++) {
            window.clearTimeout(i);
        }
        setTimeout(filter_plans, 1000);
    })
});