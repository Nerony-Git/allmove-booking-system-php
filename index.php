<?php
session_start();
if (isset($_SESSION[''])) {
    header("Location: dashboard.php");
    die();
}

include("config.php");
$msg = "";

?>

<!DOCTYPE html>
<html lang="en">
<!-- [ Head Link Start ] -->
<?php include('layout/head/head-login.php') ?>
<!-- [ Head Link End ] -->

<body>
    <div class="container">
        <div class="forms-container">
            <div class="login">
                <form action="" method="POST" class="login-form">
                    <h2 class="title">Login</h2>
                    <!-- [ Echo Msg] -->
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                    <div class="Forget-Pass">
                        <a href="#" class="Forget">Forgot Password?</a>
                    </div>

                    <div class="input-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <input type="submit" name="submit" value="Login" />
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <img src="assets/img/web/full-logo2.png" alt="">
                </div>
                <img src="assets/img/web/log.svg" alt="" class="image" />
            </div>
        </div>
    </div>

    <!-- [ Foot Link Start ] -->
    <?php include('layout/foot/foot-login.php') ?>
    <!-- [ Foot Link End ] -->

</body>

</html>