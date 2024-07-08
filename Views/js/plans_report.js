function report(){
    var plans_name = $(".plans_name").val();
    var date_from = $(".date_from").val();
    var date_to = $(".date_to").val();
    var rate_from = $(".rate_from").val();
    var rate_to = $(".rate_to").val();
    var status = $(".status:checked").val();
    if (!status){
        status = "";
    }
    var cats = [];
    for (var i = 0; i < $(".cats:checked").length; i++){
        cats.push($(".cats:checked").eq(i).val());
    }
    cats = cats.join("','");
    var cities = $(".cities").val().join("','");
    var fund = $(".fund:checked").val();
    if (!fund){
        fund = "";
    }
    var level = [];
    for (var i = 0; i < $(".level:checked").length; i++){
        level.push($(".level:checked").eq(i).val());
    }
    level = level.join("','");
    $.post("/admin/plans_report_ajax",
        {
            plans_name : plans_name,
            date_from : date_from,
            date_to : date_to,
            rate_from : rate_from,
            rate_to : rate_to,
            status : status,
            cats : cats,
            cities : cities,
            fund : fund,
            level : level
        },
        function(data, status){
            if (data !== "404" && data !== "" && status == "success") {
                var plans = JSON.parse(data);
                $(".loader").fadeIn();
                $(".loader-back").fadeIn();
                $(".plans_table").find("tbody").find("tr").remove();
                for (var i = 0; i < plans.length; i++){
                    var tr = '<tr>' +
                        '                    <td>' + plans[i]["idea_title"] + '</td>' +
                        '                    <td>' + plans[i]["judges"] + '</td>' +
                        '                    <td>' + plans[i]["idea_level"] + '</td>' +
                        '                    <td>' + plans[i]["backs"] + '</td>' +
                        '                    <td>' + convert_amount(plans[i]["fund"]) + '</td>' +
                        '                    <td>' + plans[i]["time"] +'</td>' +
                        '                    <td>' + plans[i]["rate"] + '</td>' +
                        '                    <td>' + plans[i]["owner_city"] + '</td>' +
                        '                    <td>' + plans[i]["status"] + '</td>' +
                        '                </tr>';
                    $(".plans_table").find("tbody").append(tr);
                }
                $(".loader").fadeOut();
                $(".loader-back").fadeOut();
            }
        }
    )
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
    $(".status").click(function () {
        $(this).addClass("clicked");
        $(".status:not(.clicked)").prop("checked", false);
        $(this).removeClass("clicked");
    })
    $(".fund").click(function () {
        $(this).addClass("clicked");
        $(".fund:not(.clicked)").prop("checked", false);
        $(this).removeClass("clicked");
    })
    $(".report_btn").click(function () {
        report();
    })
})