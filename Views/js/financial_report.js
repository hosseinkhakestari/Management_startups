function report(){
    var judges_name = $(".judges_name").val();
    var financial_from = $(".financial_from").val();
    var financoal_to = $(".financial_to").val();
    var cats_from = $(".cats_from").val();
    var cats_to = $(".cats_to").val();
    var cats = [];
    for (var i = 0; i < $(".cats:checked").length; i++){
        cats.push($(".cats:checked").eq(i).val());
    }
    cats = cats.join("','");
    $.post("/admin/financial_report_ajax",
        {
            judges_name : judges_name,
            financial_from : financial_from,
            financial_to : financoal_to,
            cats_from : cats_from,
            cats_to : cats_to,
            cats : cats
        },
        function (data , status) {
            if (data !== "404" && data !== "" && status == "success") {
                var judges = JSON.parse(data);
                if (judges.length > 0){
                    $(".judges_table").find("tbody").find("tr").remove();
                    $(".loader , .loader-back").fadeIn();
                    for (var i = 0; i < judges.length; i++){
                        var tr =
                            "<tr class='tr_link' id='"+ judges[i]["id"] +"'>" +
                            "<td>" + judges[i]["judge_name"] + "</td>" +
                            "<td>" + judges[i]["plans_count"] + "</td>" +
                            "<td>" + judges[i]["rated_plans"] + "</td>" +
                            "<td>" + judges[i]["category"] + "</td>" +
                            "<td>" + judges[i]["financial"] + "</td>" +
                            "</tr>";
                        $(".judges_table").find("tbody").append(tr);
                        $(".judges_table").find("tbody").find(".tr_link").click(function () {
                            window.location = "/admin/report_judge/" + this.id;
                        })
                    }
                    $(".loader , .loader-back").fadeOut();
                }
            }
        })
}
$(document).ready(function () {
    $(".judges_table").find("tbody").find(".tr_link").click(function () {
        window.location = "/admin/report_judge/" + this.id;
    });
    $(".report_btn").click(function () {
        report();
    });
});