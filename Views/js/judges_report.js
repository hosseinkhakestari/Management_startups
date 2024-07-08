function report(){
    var judges_name = $(".judges_name").val();
    var financial_from = $(".financial_from").val();
    var financoal_to = $(".financial_to").val();
    var date_from = $(".date_from").val();
    var date_to = $(".date_to").val();
    var age_from = $(".age_from").val();
    var age_to = $(".age_to").val();
    var cats = [];
    for (var i = 0; i < $(".cats:checked").length; i++){
        cats.push($(".cats:checked").eq(i).val());
    }
    cats = cats.join("','");
    $.post("/admin/judges_report_ajax",{
        judges_name : judges_name,
        financial_from : financial_from,
        financial_to : financoal_to,
        date_from : date_from,
        date_to : date_to,
        age_from : age_from,
        age_to : age_to,
        cats : cats
    }, function (data, status) {
        if (data !== "404" && data !== "" && status == "success") {
            var judges = JSON.parse(data);
            if (judges.length > 0){
                $(".judges_table").find("tbody").find("tr").remove();
                $(".loader , .loader-back").fadeIn();
                for (var i = 0; i < judges.length; i++){
                    var tr =
                        "<tr>" +
                            "<td>" + judges[i]["judge_name"] + "</td>" +
                            "<td>" + judges[i]["plans_count"] + "</td>" +
                            "<td>" + judges[i]["rated_plans"] + "</td>" +
                            "<td>" + judges[i]["category"] + "</td>" +
                            "<td>" + judges[i]["financial"] + "</td>" +
                            "<td>" + judges[i]["time"] + "</td>" +
                            "<td>" + judges[i]["age"] + "</td>" +
                            "<td><a class='btn brown-back text-white reset_pass_btn' href='/admin/reset_judge_pass/" + judges[i]["id"] + "'>" + "ریست پسورد" + "</a></td>" +
                        "</tr>";
                    $(".judges_table").find("tbody").append(tr);
                }
                $(".loader , .loader-back").fadeOut();
                $(".reset_pass_btn").click(function () {
                    reset_pass(this);
                    return false;
                });
            }
        }
    })
}
function reset_pass(item){
    var href = $(item).attr("href");
    $.confirm({
        title: '',
        content: '<p style="text-align: right !important;">پسورد کاربر ریست شود؟</p>',
        buttons: {
            بله: function () {
                $.post(href,{reset : "OK"},function (data, status) {
                    console.log(status);
                    var res = "";
                    if (status == "success" && data == "OK"){
                        res = "انجام شد";
                    } else{
                        res = "دوباره امتحان کنید";
                    }
                    $.alert({
                        title: '',
                        content: '<p style="text-align: right">' + res + '</p>',
                        buttons: {
                            باشه:function () {

                            }
                        }
                    });
                })
            },
            خیر: function () {
            }
        }
    });
}
$(document).ready(function () {
    $(".date_from").persianDatepicker({
        altField: '.date_input',
        altFormat: "YYYY/MM/DD",
        observer: true,
        format: 'YYYY/MM/DD',
        initialValue: false,
        initialValueType: 'persian',
        autoClose: true,
        maxDate: 'today',
        autoClose: true,
        viewMode: 'year'
    });
    $(".date_to").persianDatepicker({
        altField: '.date_input',
        altFormat: "YYYY/MM/DD",
        observer: true,
        format: 'YYYY/MM/DD',
        initialValue: false,
        initialValueType: 'persian',
        autoClose: true,
        maxDate: 'today',
        autoClose: true,
        viewMode: 'year'
    });
    $(".report_btn").click(function () {
        report();
    });
    $(".reset_pass_btn").click(function () {
        reset_pass(this);
        return false;
    });
})