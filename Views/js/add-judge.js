$(document).ready(function () {
    $(".add-judge-img-btn").click(function () {
        $(".judge-img-input").click();
    });
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
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
    //     autoClose: true
    // });
    $(".judge-img-input").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.member-image-upload').attr('src', e.target.result);
                $(".member_image_input").val(e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $(".save_judge_btn").click(function () {
        $.confirm({
            title: '',
            content: '<p style="text-align: right !important;">آیا اطمینان دارید؟</p>',
            buttons: {
                بله: function () {
                    setTimeout(function () {
                        $(".save_judge").click();
                    },500);
                },
                خیر: function () {
                }
            }
        });
    });
});