<?php
session_start();

if (isset($_COOKIE['remember_me_admin']) || isset($_COOKIE['remember_me_mahasiswa'])) {
    if (isset($_COOKIE['remember_me_admin'])) {
        header("Location: admin/admin_dashboard.php");
        exit();
    } elseif (isset($_COOKIE['remember_me_mahasiswa'])) {
        header("Location: user/mhs_dashboard.php");
        exit();
    }
}

if (isset($_POST['signin'])) {
    require_once 'model/db_connect.php';

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = 'Isi username dan password. Silakan coba lagi.';
    } else {
        $usernameadmin = $email;
        $admin_sql = "SELECT * FROM admin WHERE username='$usernameadmin'";
        $admin_result = $conn->query($admin_sql);

        if ($admin_result->num_rows > 0) {
            $row = $admin_result->fetch_assoc();

            if ($password === $row['password']) {
                $_SESSION['admin_username'] = $usernameadmin;
                $_SESSION['admin_id'] = $row['ID_Admin'];

                if (isset($_POST['rememberMe'])) {
                    $cookie_name = 'remember_me_admin';
                    $cookie_value = base64_encode($usernameadmin . ':' . $password);
                    setcookie($cookie_name, $cookie_value, time() + (30 * 24 * 60 * 60), "/");
                }
                $_SESSION['success_message'] = 'Login Berhasil, Selamat Datang.';
                header("Location: admin/admin_dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = 'Password admin salah. Silakan coba lagi.';
            }
        } else {
            $mahasiswa_sql = "SELECT * FROM mahasiswa WHERE email='$email'";
            $mahasiswa_result = $conn->query($mahasiswa_sql);

            if ($mahasiswa_result->num_rows > 0) {
                $row = $mahasiswa_result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION['mahasiswa_username'] = $email;
                    $_SESSION['mahasiswa_id'] = $row['ID_Mahasiswa'];

                    if (isset($_POST['rememberMe'])) {
                        $cookie_name = 'remember_me_mahasiswa';
                        $cookie_value = base64_encode($email . ':' . $password);
                        setcookie($cookie_name, $cookie_value, time() + (30 * 24 * 60 * 60), "/");
                    }
                    $_SESSION['success_message'] = 'Login Berhasil, Selamat Datang.';
                    header("Location: user/mhs_dashboard.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = 'Password mahasiswa salah. Silakan coba lagi.';
                }
            } else {
                $_SESSION['error_message'] = 'Username tidak ditemukan. Silakan coba lagi.';
            }
        }
    }

    $conn->close();
}

include ('assets/view/resources_auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

</head>

<body>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="assets/images/signin.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In</h5>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo isset($_COOKIE['remember_me_username']) ? $_COOKIE['remember_me_username'] : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text eye-icon" id="eye-icon" onclick="togglePassword()">
                                            <i class="fa fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe"
                                    <?php echo isset($_COOKIE['remember_me_username']) ? 'checked' : ''; ?> >
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="signin">Sign In</button>
                        </form>
                        <p class="text-center">Belum Punya Akun? <a href="register.php" style="text-decoration: none;">Sign Up</a></p>
                    </div>
                </div>

                <div class="position-absolute top-0 end-0 m-3" style="z-index: 5">
                    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Notification</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <!-- // body from server -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        function togglePassword() {
            var x = document.getElementById("password");
            var icon = document.getElementById("eye-icon");

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
                toastEl.classList.remove('bg-success', 'text-dark');
            } else {
                toastEl.classList.add('bg-success', 'text-light');
                toastEl.classList.remove('bg-danger', 'text-dark');
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
