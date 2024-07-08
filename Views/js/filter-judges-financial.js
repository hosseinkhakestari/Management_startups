function slide_down(){
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
}
function filter_judges(){
    var startup_back = $("input.startup_back:checked");
    var back_filters = "";
    for (var i = 0; i < startup_back.length; i++){
        back_filters += "'" + startup_back.eq(i).val() + "'" + ",";
    }
    back_filters = back_filters.substring(0, back_filters.length - 1);
    var order = $("#plans_order").val();
    if (!order){
        order = "";
    }
    if (order.indexOf("idea_title") > -1){
        order = order.replace("idea_title", "judge_name");
    }
    var searched = $(".search-plans").val();
    $.post("/admin/filter_judges",
        {
            filter_judges : 1,
            back_filters: back_filters,
            order : order,
            searched : searched
        },
        function(data, status){
            if (data !== "404" && data !== "" && status == "success"){
                $(".loader").fadeIn();
                $(".loader-back").fadeIn();
                $(".plans_tr").remove();
                var judges = JSON.parse(data);
                for (var i = 0; i < judges.length; i++){
                    var financial = judges[i]["financial"];
                    if (financial == 0){
                        financial = "";
                    }
                    var tr = '<tr class="border-bottom plans_tr">' +
                        '                                    <td style="padding-top: 25px; padding-bottom: 5px; width: 33%;">' + judges[i]["judge_name"] + '</td>' +
                        '                                    <td style="width: 33%;">' + judges[i]["plans_count"] + '</td>' +
                        '                                    <td style="padding-top: 25px; padding-bottom: 5px; width: 33%;">' +
                        '                                        <input type="text" name="judge'+ judges[i]["id"] +'" placeholder="مبلغ" class="form-control mx-auto py-1 fa-back none-spinner amount_input text-center" id="amount_input" style="width: 100px;" value="'+ convert_amount(financial) +'">' +
                        '                                    </td>' +
                        '                                </tr>';
                    $(".plans_tbody").append(tr);
                    $(".plans_tbody").find("input:text").on("input", function () {
                        add_semi(this);
                    });
                }
                $(".loader").fadeOut();
                $(".loader-back").fadeOut();
            }
        }
        );
}
$(document).ready(function () {
    slide_down();
    $("input.startup_back").click(function () {
        filter_judges();
    });
    $("#plans_order").change(function () {
        filter_judges();
    });
    $(".search-plans").on("input", function () {
        for (var i = 1; i < 99999; i++) {
            window.clearTimeout(i);
        }
        setTimeout(filter_judges, 1000);
    })
});