function register() {
    username = $("#username").val();
    password = $("#password").val();
    repassword = $("#repeat_password").val();
    if (username && password && repassword) {

        if (password == repassword){
            $.ajax({
                url: "api/ajax/register.php",
                type: 'POST',
                cache: false,
                data: {
                    username: username,
                    password: password
                },
                success: function () {
                    window.location.href = "login.php";
                },
                error: function (jqXHR) {
                    toastr.error(jqXHR.responseText, 'ERROR')
                }
            });
        }else{
            toastr.error('The passwords dosent match', 'ERROR')
        }

    }else{
        toastr.error('Please complete all available fields ', 'ERROR')
    }
}