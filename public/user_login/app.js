$(document).ready(function(){
    $(".eye").click(function(){
        var passwordField = $("#password");
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
    let otp_button = $('.otp_button');
    let login_button = $('.login_button');
    let password_input = $('.password_input');

    login_switch.on('click',function(){
        login_switch.parent('p').hide();
        otp_switch.parent('p').show();
        login_title.show();
        otp_title.hide();
        login_button.show();
        otp_button.hide();
        password_input.show();
    });
    otp_switch.on('click',function(){
        login_switch.parent('p').show();
        otp_switch.parent('p').hide();
        login_title.hide();
        otp_title.show();
        login_button.hide();
        otp_button.show();
        password_input.hide();
    });

    
});