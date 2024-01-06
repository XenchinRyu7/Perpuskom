<?php
session_start();

if (isset($_POST['signup'])) {
    require_once '../model/db_connect.php';

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $re_pass = $_POST['re-password'];

    if ($pass != $re_pass) {
        $_SESSION['error_message'] = 'Password tidak cocok. Silakan coba lagi.';
    } else {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO mahasiswa (Nama, email, Password) VALUES ('$name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = 'Registrasi Berhasil. Silakan login.';
        } else {
            $_SESSION['error_message'] = 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }

    $conn->close();
}

include('assets/view/resources_auth.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="assets/images/signup.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign Up</h5>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text eye-icon" id="eye-icon1"
                                            onclick="togglePassword('password')">
                                            <i class="fa fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="retype-password" class="form-label">Retype Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="retype-password" name="re-password"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text eye-icon" id="eye-icon2"
                                            onclick="togglePassword('retype-password')">
                                            <i class="fa fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="signup">Sign Up</button>
                        </form>
                        <p class="text-center">Sudah Daftar? <a href="index.php" style="text-decoration: none;">Sign
                                In</a></p>
                    </div>
                </div>

                <div class="position-absolute top-0 end-0 m-3" style="z-index: 5">
                    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Notification</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <!-- from server -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            var x = document.getElementById(inputId);
            var iconId = inputId === "retype-password" ? "eye-icon2" : "eye-icon1";
            var icon = document.getElementById(iconId);

            if (x.type === "password") {
                x.type = "text";
                icon.innerHTML = '<i class="fa fa-solid fa-eye-slash"></i>';
            } else {
                x.type = "password";
                icon.innerHTML = '<i class="fa fa-solid fa-eye"></i>';
            }
        }

        function showToast(message, isError = true) {
            var toastEl = document.getElementById('liveToast');
            var toastInstance = new bootstrap.Toast(toastEl);

            if (isError) {
                toastEl.classList.add('bg-danger', 'text-light');
            } else {
                toastEl.classList.remove('bg-danger', 'text-light');
            }

            document.querySelector('.toast-body').innerHTML = message;
            toastInstance.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "showToast('{$_SESSION['error_message']}', true);";
                unset($_SESSION['error_message']);
            }

            if (isset($_SESSION['success_message'])) {
                echo "showToast('{$_SESSION['success_message']}', false);";
                unset($_SESSION['success_message']);
            }
            ?>
        });
    </script>
</body>

</html>