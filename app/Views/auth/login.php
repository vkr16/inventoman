<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Manager</title>
    <link rel="shortcut icon" href="public/assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/assets/library/bootstrap-5.2.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/library/fontawesome-6.2.0/css/all.min.css">
    <link rel="stylesheet" href="public/assets/css/custom.css">
</head>

<body>

    <section id="Login">
        <div class="wh-screen d-flex justify-content-center align-items-center bg-white font-nunito-sans">
            <div class="col-10" style="max-width: 480px">
                <p class="display-5 fw-semibold font-poppins">Login</p>
                <p class="h5 fw-normal">Log in to your account</p>
                <hr style="max-width: 320px" class="mt-2 mb-4">
                <form>
                    <div class="mb-3">
                        <label for="inputUsername" class="form-label">Username</label>
                        <input required autocomplete="username" type="text" class="form-control rounded-0" id="inputUsername" <?= isset($_COOKIE['inventoman_last_user']) ? 'value="' . $_COOKIE['inventoman_last_user'] . '"' : 'autofocus' ?>>
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input required autocomplete="current-password" type="password" class="form-control rounded-0" id="inputPassword" <?= isset($_COOKIE['inventoman_last_user']) ? 'autofocus' : '' ?>>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 d-flex align-items-center me-auto">
                            <input type="checkbox" class="form-check-input rounded-0 mt-0" id="checkShowpassword" onchange="passwordVisible()">
                            <label for="checkShowpassword" class="form-label mb-0 ms-2">Show password</label>
                        </div>
                        <!-- <a href="reset-password.php" class="text-primary ms-auto">Forgot password?</a> -->
                    </div>
                    <div class="mb-3 d-flex align-items-center me-auto">
                        <input type="checkbox" class="form-check-input rounded-0 mt-0" id="checkRememberme" <?= isset($_COOKIE['inventoman_last_user']) ? "checked" : '' ?>>
                        <label for="checkRememberme" class="form-label mb-0 ms-2">Remember username</label>
                    </div>
                    <button type="button" class="btn btn-primary rounded-0" onclick="login()" id="loginButton"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                </form>

                <!-- <p class="mt-3">Or <a href="register.php">Create an account</a></p> -->
                <p class="small text-muted text-center mt-5">&copy; 2022 Company Name <br> Inventoman v1.0</p>
            </div>
        </div>
    </section>

    <script src="public/assets/library/bootstrap-5.2.2/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/library/jquery-3.6.1.min.js"></script>
    <script src="public/assets/library/notiflix-aio-3.2.5.min.js"></script>

    <script>
        function passwordVisible() {
            if (document.getElementById('inputPassword').type == "password") {
                document.getElementById('inputPassword').type = "text"
            } else {
                document.getElementById('inputPassword').type = "password"
            }
        }

        Notiflix.Notify.init({
            borderRadius: "0px",
            showOnlyTheLastOne: true,
            position: "center-top",
            cssAnimationStyle: "from-top"
        })

        $('#inputPassword').on('keypress', function(e) {
            if (e.which == 13) {
                $('#loginButton').click()
            }
        });

        function login() {
            $('#inputUsername').val() == '' ? $('#inputUsername').addClass('is-invalid') : $('#inputUsername').removeClass('is-invalid')
            $('#inputPassword').val() == '' ? $('#inputPassword').addClass('is-invalid') : $('#inputPassword').removeClass('is-invalid')

            const username = $('#inputUsername').val()
            const password = $('#inputPassword').val()
            const saveuser = $('#checkRememberme').is(":checked")

            $.post("auth", {
                    username: username,
                    password: password,
                    saveuser: saveuser
                })
                .done(function(data) {
                    console.log(data)
                    if (data == 'incorrect') {
                        Notiflix.Notify.failure("Password incorrect!")
                    } else if (data == 'notfound') {
                        Notiflix.Notify.failure("User not found!")
                    } else if (data == 'empty') {
                        Notiflix.Notify.warning("Field cannot be empty!")
                    } else if (data == 'success') {
                        window.location.replace("admin");
                    }
                });
        }
    </script>
</body>

</html>