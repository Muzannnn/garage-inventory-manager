function login() {
    username = $("#username").val();
    password = $("#password").val();
    if (username && password) {

        $.ajax({
            url: "api/ajax/login.php",
            type: 'POST',
            cache: false,
            data: {
                username: username,
                password: password
            },
            success: function () {
                window.location.href = "dashboard.php";
            },
            error: function (jqXHR) {
                $.notify({
                    message: jqXHR.responseText
              
                },{
                    type: 'danger',
                    timer: 4000,
                    placement: {
                        from: "top",
                        align: "right"
                    }
                });
            }
        });
    } else {
        $.notify({
            message: "Veuilliez remplir tous les champs"
      
        },{
            type: 'danger',
            timer: 4000,
            placement: {
                from: "top",
                align: "right"
            }
        });
    }
}