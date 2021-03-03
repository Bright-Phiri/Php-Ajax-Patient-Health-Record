$(document).ready(function () {
    createAccount();
    userLogin();
    viewUsers();
    validateInputFields();
});

function validateInputFields(){
    $("#username").on("keyup blur", function () {
        var username = $(this).val();
        $.post(
            "../Controller/createAccountController.php",
            { username: username },
            function (response) {
                if (response == "true") {
                    $("#username_status").text("That username is taken. Try another");
                    $("#createAccountBtn").attr("disabled", true);
                } else {
                    $("#username_status").text("");
                    $("#createAccountBtn").removeAttr("disabled");
                }
            }
        );
    });

    $("#email").on("keyup blur", function () {
        var email = $(this).val();
        if (email != "") {
            $.post(
                "../Controller/createAccountController.php",
                { email: email },
                function (response) {
                    if (response == "true") {
                        $("#email_status").text(
                            "The email address is already taken. Try another"
                        );
                        $("#createAccountBtn").attr("disabled", true);
                    } else {
                        $("#email_status").text("");
                        $("#createAccountBtn").removeAttr("disabled");
                    }
                }
            );
        }
    });

    $("#password").on("keyup blur", function () {
        var password = $(this).val();
        if (password != "") {
            if (password.length < 8) {
                $("#password_status").text(
                    "Password is too short(must be atleast 8 characters)"
                );
                $("#createAccountBtn").attr("disabled", true);
            } else {
                if (password.length > 8) {
                    $("#password_status").text(
                        "Password is too long(must be atleast 8 characters)"
                    );
                    $("#createAccountBtn").attr("disabled", true);
                }
                if (password.length == 8){
                    $("#password_status").text(""); 
                    $("#createAccountBtn").removeAttr("disabled"); 
                }
            }
        } else{
            $("#password_status").text(""); 
        }
    });

    $("#confirm-password").on("keyup blur", function () {
        var confirm_password = $(this).val();
        var password = $("#password").val();
        if (confirm_password != "" && password != "") {
            if (password != confirm_password){
               
                $("#confirm_password_status").text("Those passwords didn't match. Try again."); 
                $("#createAccountBtn").attr("disabled", true);
                
            } else{
                $("#confirm_password_status").text(""); 
                $("#createAccountBtn").removeAttr("disabled"); 
            }
        } else{
            $("#confirm_password_status").text(""); 
        }
    });

}

function createAccount() {
    $("#createAccountBtn").click(function () {
        var username = $("#username").val();
        var emailAddress = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirm-password").val();
        if (
            username == "" ||
            emailAddress == "" ||
            password == "" ||
            confirmPassword == ""
        ) {
            //Fields validation
            showAlert(
                "Fields Validation",
                "Please enter in all fields",
                "warning",
                "Ok"
            );
        } else {
            var pattern = /^[a-zA-Z ]+$/;
            var email_pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!username.match(pattern)) {
                showAlert("Fields Validation", "Username is invalid", "warning", "Ok");
            } else if (!emailAddress.match(email_pattern)) {
                showAlert("Fields Validation", "Email is invalid", "warning", "Ok");
            } else if (password != confirmPassword) {
                showAlert("Password validation", "Passwords dont match", "error", "Ok");
            } else if (password.trim().length < 8) {
                showAlert(
                    "Password validation",
                    "Password must contain atleast 8 characters.",
                    "error",
                    "Ok"
                );
                $("#password").focus();
                $("#confirm-password").focus();
            } else {
                var formData = $("#create-account-from").serialize();
                $.ajax({
                    url: "../Controller/createAccountController.php",
                    method: "post",
                    data: formData,
                    dataType: "JSON",
                    success: function (response) {
                        showAlert1(response[0], response[1], response[2], response[3]);
                    },
                    error: function (response) {
                        showAlert(response[0], response[1], response[2], response[3]);
                    },
                });
            }
        }
    });
}

function userLogin() {
    $("#loginBtn").click(function () {
        var email = $("#email").val();
        var password = $("#password").val();
        if (email == "" || password == "") {
            showAlert(
                "Fields Validation",
                "Please enter in all fields",
                "warning",
                "Ok"
            );
        } else {
            $.ajax({
                url: "../Controller/userLoginController.php",
                method: "post",
                dataType: "JSON",
                data: {
                    umail: email,
                    upass: password,
                },
                success: function (response) {
                    if (response[1] === "success") {
                        window.location.href = "../view/index.php";
                    } else {
                        showAlert(response[0], response[1], response[2], response[3]);
                    }
                },
            });
        }
    });

    $("input[type='password']").keypress(function (e) {
        var code = e.which;
        if (code == 13) {
            $("#loginBtn").click();
        }
    });

    $("#cancel-add-user-btn").click(function () {
        $("form").trigger("reset");
    });
}

function viewUsers() {
    $.ajax({
        url: "../Controller/viewUsersController.php",
        method: "post",
        success: function (data) {
            data = $.parseJSON(data);
            $("#table").html(data.content);
            $("#usertable").DataTable();
        },
    });
}

function showAlert1(title, message, iconName, buttonText) {
    swal({
        title: title,
        text: message,
        icon: iconName,
        button: buttonText,
    }).then(function () {
        if (title == "Warning") {
        } else {
            window.location.href = "../index.php";
        }
    });
}

function showAlert(title, message, iconName, buttonText) {
    swal({
        title: title,
        text: message,
        icon: iconName,
        button: buttonText,
    });
}
