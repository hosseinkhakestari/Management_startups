function check_file_size(elem, allow, remove) {
    if (elem.files && elem.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var to_remove = data.split(",");
            var to_remove = to_remove[0];
            data = data.replace(to_remove + "," , "");
            var len = data.length;
            var sizeInBytes = 4 * Math.ceil((len / 3))*0.5624896334383812;
            var size = sizeInBytes/1000000;
            if (size > allow){
                $.alert({
                    title: '',
                    content: '<p style="text-align: right">' + "حجم فایل میبایست کمتر از " + allow + " مگابایت باشد" + '</p>',
                    buttons: {
                        باشه:function () {}
                    }
                });
                $(elem).parent().find("p").last().remove();
                if (!remove){
                    $(elem).remove();
                }else{
                    $(elem).val(null);
                }
            }
        }
        reader.readAsDataURL(elem.files[0]);
    }
}

function check_lang(input){
    var exept = ["username", "amount_input", "eng"];
    if (exept.indexOf($(input).attr("id")) > -1){
        return;
    }
    var val = $(input).val();
    var p = /^[\u0600-\u06FF\s.123456789]+$/;
    if (!p.test(val) && val.length > 0) {
        $(input).val(val.slice(0,-1));
        $.alert({
            title: '',
            content: '<p style="text-align: right">' + 'لطفا متن را به فارسی تایپ کنید' + '</p>',
            buttons: {
                باشه:function () {
                }
            }
        });
    }
}

$(document).ready(function () {
    $(".loader").fadeOut();
    $(".loader-back").fadeOut();
    $("body").css("overflow", "scroll");
    $("input[type=file]").on("change", function () {
        check_file_size(this, 20, true);
    });
    $("input:text , textarea").on("input", function () {
        check_lang($(this));
    });
    // $(".date_input").persianDatepicker({
    //     altField: '.date_input',
    //     altFormat: "YYYY/MM/DD",
    //     observer: true,
    //     format: 'YYYY/MM/DD',
    //     initialValue: false,
    //     initialValueType: 'persian',
    //     autoClose: true,
    //     maxDate: 'today',
    //     autoClose: true,
    //     viewMode: 'year'
    // });
    // $('.select2').select2();
    $(".date_input").click(function () {
        $(".loader").fadeIn();
        $(".loader-back").fadeIn();
        $(".date_sec").fadeIn();
        var input = this;
        $(".date_sec").find("button").click(function () {
            var day = $(".date_sec").find("select").eq(0).val();
            var month = $(".date_sec").find("select").eq(1).val();
            var year = $(".date_sec").find("select").eq(2).val();
            if (!day || !month || !year){
                $.alert({
                    title: '',
                    content: '<p style="text-align: right">همه‌ی موارد را وارد کنید!</p>',
                    buttons: {
                        باشه:function () {}
                    }
                });
            }else{
                var date = year + "/" + month + "/" + day;
                $(input).val(date);
                $(".date_sec").find("select").val("");
                $(".date_sec").fadeOut();
                $(".loader").fadeOut();
                $(".loader-back").fadeOut();
                $(this).off("click");
            }
        });
    });
    $(".date_sec").find(".close-date-form").click(function () {
        $(".date_sec").fadeOut();
        $(".loader").fadeOut();
        $(".loader-back").fadeOut();
        $(".date_sec").find("select").val("");
    });
    var window_height = window.innerHeight;
    var nav = $("nav");
    if (nav.length > 0){
        var add_form_height = window_height - 160;
        var add_form_top = 150;
    } else{
        var add_form_height = window_height - 40;
        var add_form_top = 30;
    }
    var content_form_height = add_form_height - 116;
    $(".add-member-form").css("cssText", "max-height: "+ add_form_height +"px !important; display:none; top:"+ add_form_top +"px !important;");
    $(".add-form-content").css("cssText", "max-height:"+ content_form_height +"px !important;");
    if ($(".select2city").length > 0){
        $(".select2city").select2({
            placeholder : "شهر - استان",
            dir : "rtl"
        });
        if ($(".select2city").hasClass("city")){
            // $(".select2-selection").css("cssText", "background:red !important;");
            $(".select2-selection").addClass("fa-back");
        }
    }
    if ($(".select2pname").length > 0){
        $(".select2pname").select2({
            placeholder : "نام طرح(ها)",
            dir : "rtl"
        });
    }
    if ($(".select2jname").length > 0){
        $(".select2jname").select2({
            placeholder : "نام ارزیاب(ها)",
            dir : "rtl"
        });
    }
    $(".filter-items2 , .filter-items").find("input").click(function () {
        $(this).parent().click();
    });
    $(".checkbox-p2 ,  .checkbox-p").click(function () {
        var input = $(this).find("input");
        if (input.prop("checked")){
            input.prop("checked", false);
        } else{
            input.prop("checked", true);
        }
        if ($(this).hasClass("checkbox-p")){
            filter_plans();
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                if (this.value == ""){
                    e.target.setCustomValidity("فیلدهای ستاره دار الزامی میباشد");
                } else{
                    e.target.setCustomValidity("مقدار را به درستی وارد کنید");
                }
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})

document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("select");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                if (this.value == ""){
                    e.target.setCustomValidity("فیلدهای ستاره دار الزامی میباشد");
                } else{
                    e.target.setCustomValidity("مقدار را به درستی وارد کنید");
                }
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})

document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("textarea");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                if (this.value == ""){
                    e.target.setCustomValidity("فیلدهای ستاره دار الزامی میباشد");
                } else{
                    e.target.setCustomValidity("مقدار را به درستی وارد کنید");
                }
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
});

function convert_amount(val) {
    var neww = "";
    var amount = val.split("").reverse().join("");
    for (var i = 0; i < amount.length; i++){
        if(i%3 == 0 && i !== 0){
            neww += "," + amount[i];
        }else{
            neww += amount[i];
        }
    }
    return neww.split("").reverse().join("");
}
$("form").submit(function () {
    $(".loader").fadeIn();
    $(".loader-back").fadeIn();
});

function add_semi(item){
    var value = $(item).val();
    var p = /^[0-9]+$/;
    value = value.replace(/\,/g , "");
    if (!p.test(value) && value.length > 0){
        $(item).val($(item).val().slice(0,-1));
    }else{
        $(item).val(convert_amount(value));
    }
}

$(".amount_input").on("input", function () {
    add_semi(this);
});

function edit_jds(button){
    $("input.all_judges").prop("checked", false);
    var plan = button.id;
    $.post("/admin/get_plan_judges/"+plan,
        {},
        function(data, status){
            if (status == "success"){
                var data = JSON.parse(data);
                for (var i = 0; i < data.length; i++){
                    $("input.all_judges[value="+ data[i] +"]").prop("checked", true);
                }
            }
        });
    $(".add-plan-back").fadeIn();
    $(".edit-judges-form").fadeIn();
    $(".confirm-edit-judges-btn").off("click");
    $(".confirm-edit-judges-btn").click(function () {
        edit_judges(plan);
    });
}