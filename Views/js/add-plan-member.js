function file_input_change(input){
    var fullPath = input.value;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        var p = document.createElement('p');
        p.classList.add("fa-back");
        p.classList.add("font-size-13")
        p.classList.add("py-2")
        p.classList.add("px-0")
        p.classList.add("m-0")
        p.classList.add("radius-10")
        p.classList.add("mt-1")
        p.classList.add("d-block")
        p.classList.add("text-center");
        p.setAttribute("dir", "ltr");
        p.style.position = "relative";
        $(p).append("<span style='display: inline-block; width: calc(100% - 20px);'>"+filename+"</span>");
        var span = document.createElement('span');
        span.setAttribute('style', 'display: inline-block; width: 20px; text-align: center; position: absolute; top: calc(50% - 10px); right: 1px;');
        var i = document.createElement('i');
        i.classList.add("fas")
        i.classList.add("fa-plus");
        i.setAttribute('style', 'transform: rotate(45deg); vertical-align: middle; font-size: 16px; cursor: pointer;');
        $(i).click(function () {
            $(p).remove();
            $(input).remove();
        });
        $(span).append(i);
        $(p).append(span);
        $(input).parent().append(p);
    }
    check_file_size(input, 20);
}
$(document).ready(function () {
    //add show form function
    $(".add-member-botton").click(function () {
        $(".add-member-form").fadeIn("Slow");
        $(".add-plan-back").css("display", "block");
        $("body").css("overflow", "hidden");
    });
//    hide add memeber form
    function hide_member_form(){
        $(".add-member-form").fadeOut("Slow");
        $(".add-member-form").find("input").val("");
        $(".add-member-form").find("textarea").val("");
        $(".add-plan-back").css("display", "none");
        $(".member-image-upload").attr("src", "Views/images/member-default.png");
        $("body").css("overflow", "scroll");
    }
    $(".close-form-button").click(hide_member_form);
//    render image in memeber form
    $(".add-member-image-btn").click(function () {
        $("#member-image-input").click();
    });
    $("#member-image-input").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.member-image-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    })
//    add user info to main form
    $(".save-member-btn").click(function () {
        var img_src = $(".member-image-upload").attr("src");
        var stringLength = img_src.length - 'data:image/png;base64,'.length;
        var sizeInBytes = 4 * Math.ceil((stringLength / 3))*0.5624896334383812;
        var fl_name = $(".add-member-form").find("input").eq(1).val();
        var birth_date = $(".add-member-form").find("input").eq(2).val();
        var this_year = new persianDate().year();
        var birth_year = birth_date.split("/")[0];
        var nums = ["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"];
        for (var i = 0; i < 10; i++){
           birth_year = birth_year.replace(nums[i], i);
        }
        var age = this_year - birth_year;
        var certificate = $(".add-member-form").find("input").eq(3).val();
        var history = $(".add-member-form").find("textarea").val();
        if (fl_name.trim() !== "" && birth_date.trim() !== "" && certificate.trim() !== ""){
            if(sizeInBytes > 1000000 && img_src.trim() !== "Views/images/member-default.png"){
                $.alert({
                    title: '',
                    content: '<p style="text-align: right">' + 'حجم تصویر میبایست کمتر از ۵ مگابایت باشد' + '</p>',
                    buttons: {
                        باشه:function () {}
                    }
                });
                return;
            }
                var new_section = document.createElement('div');
                $(new_section)
                    .addClass("col-lg-4 p-2 main-member-box")
                    .css("display", "none");
                var div = document.createElement("div");
                $(div)
                    .addClass("fa-shadow radius-10 p-3 font-size-13 member-box")
                    .css("position", "relative")
                    .append('<img src="'+ img_src +'" alt="" class="member-image">\n' +
                        '                <div class="d-inline-block member-det-parent">\n' +
                        '                    <span>نام و نام خانوادگی: '+fl_name+'</span>\n' +
                        '                    <br>\n' +
                        '                    <span>مدرک تحصیلی: '+certificate+'</span>\n' +
                        '                    <br>\n' +
                        '                    <span>تاریخ تولد: '+birth_date+'</span>\n' +
                        '                </div>\n' +
                        '                <p class="my-2">سوابق</p>\n' +
                        '                <p class="text-justify font-weight-light">' + history + '</p>');
                var trash = document.createElement("i");
                $(trash)
                    .addClass("fa fa-trash")
                    .attr("aria-hidden", true)
                    .css({"position":"absolute", "top":"1rem","left":"1rem","cursor":"pointer"});
                $(div).append(trash);
                $(new_section).append(div);
                $(".member-box-after").eq(0).before(new_section);
                $(".main-member-box").last().fadeIn(1000);
                hide_member_form();
                $(new_section)
                    .append("<input type='hidden' name='members_image[]' value='"+img_src+"'>")
                    .append("<input type='hidden' name='members_name[]' value='"+fl_name+"'>")
                    .append("<input type='hidden' name='members_birth[]' value='"+birth_date+"'>")
                    .append("<input type='hidden' name='members_age[]' value='"+age+"'>")
                    .append("<input type='hidden' name='members_certificate[]' value='"+certificate+"'>")
                    .append("<input type='hidden' name='members_history[]' value='"+history+"'>");
                $(trash).click(function () {
                    $.confirm({
                        title: '',
                        content: '<p style="text-align: right !important;">آیا از حذف عضو تیم اطمینان دارید؟</p>',
                        buttons: {
                            بله: function () {
                                $(new_section).fadeOut(1000);
                                setTimeout(function () {
                                    $(new_section).remove();
                                    },1000);
                            },
                            خیر: function () {
                            }
                        }
                    });
                });
        }else{
            var message;
            if (fl_name.trim() == ""){
                message = "نام را وارد کنید!";
            } else if (birth_date.trim() == ""){
                message = "تاریخ تولد را وارد کنید!";
            } else if(certificate.trim() == ""){
                message = "مدرک تحصیلی را وارد کنید!";
            }
            $.alert({
                title: '',
                content: '<p style="text-align: right;">' + message + '</p>',
                buttons: {
                    باشه:function () {}
                }
            });
        }
    });
//    add concept file
    $(".add-concept").click(function () {
        var input = document.createElement('input');
        input.type = "file";
        input.name = "concept_files[]";
        input.id = "concept-file";
        input.style.display = "none";
        // input.setAttribute('accept', ".apk,.mp4");
        $(".add-concept").parent().append(input);
        input.click();
        input.addEventListener('change', function () { file_input_change(input); });
    });
//    add presentation file
    $(".presentation-btn").click(function () {
        var input = document.createElement('input');
        input.type = "file";
        input.name = "presentation_files[]";
        input.id = "presentation-file";
        input.style.display = "none";
        input.setAttribute('accept', ".pptx,.ppt,.pdf,.doc,.docx");
        $(".presentation-btn").parent().append(input);
        input.click();
        input.addEventListener('change', function () { file_input_change(input); });
    });

    $("#amount_input , .amount_input").on("input", function () {
        add_semi(this);
    });
});