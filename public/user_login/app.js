$(document).ready(function(){
    $(".eye").click(function(){
        var passwordField = $(".password");
        var eyeIcon = $("#eye-icon");

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            eyeIcon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            eyeIcon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
});

$(document).ready(function(){
    let login_switch = $('.login_switch');
    let otp_switch = $('.otp_switch');

    let otp_title = $('.otp_title');
    let login_title = $('.login_title');
    let otp_form = $('.otp_form');
    let login_form = $('.login_form');

    login_switch.on('click',function(){
        login_title.show();
        otp_title.hide();
        otp_form.hide()
        login_form.show();
    });
    otp_switch.on('click',function(){
        login_title.hide();
        otp_title.show();
        login_form.hide();
        otp_form.show()
    });

    
});

