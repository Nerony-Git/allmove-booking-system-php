<?php
include("assets/connection/config.php");

// Validate request to login
if (isset($_SESSION[''])) {
    session_start();
}

// Function to generate verification code
function genVerification()
{
    return mt_rand(100000, 999999);
}

// Function to send verification code


// Confirm login
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

// Handle Login submission
if (isset($_POST['submit'])) {
    $loginUsername = $_POST['username'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "verification.php";
    $MM_redirectLoginFailed = "index.php";
    $MM_redirecttoReferrer = false;

    // Get username from form
    $username = mysqli_real_escape_string($all_move, $_POST['username']);
    $password = mysqli_real_escape_string($all_move, $_POST['password']);

    // Retrieve user with the provided username from the database
    $login_user_query = "SELECT * FROM user_profile WHERE username = '$username' AND password = '$password'";
    $login_user = mysqli_query($all_move, $login_user_query) or die(mysqli_error($all_move));
    $loginFoundUser = mysqli_num_rows($login_user);

    if ($loginFoundUser) {
        $verificationCode = genVerification();
        $registerUserLogin_query = "INSECT INTO user_login (username, password, otp) VALUES ('$username', '$password', '$verificationCode')";
        $registerUserLogin = mysqli_query($all_move, $registerUserLogin_query) or die(mysqli_error($all_move));
        $loginStrGroup = "";

        if (PHP_VERSION >= 5.1) {
            session_regenerate_id(true);
        } else {
            session_regenerate_id();
        }

        //declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }

        header("Location: " . $MM_redirectLoginSuccess . "?id=" . $username);
    } else {
        header("Location: " . $MM_redirectLoginFailed);
    }
}

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