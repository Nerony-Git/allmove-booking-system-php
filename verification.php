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
    $MM_redirectLoginSuccess = "dashboard.php";
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
                    <h2 class="title">Verify Login</h2>
                    <br />
                    <br />
                    <br />

                    <h3>Provide OTP.</h3>
                    <p><small><i class="fas fa-info-circle"></i> &nbsp; Check your email for the OTP</small></p>
                    <br />

                    <div class="input-otp" id="otp">
                        <input type="text" maxlength="1" oninput="moveToNextInput(1)" /> &nbsp;
                        <input type="text" maxlength="1" oninput="moveToNextInput(2)" /> &nbsp;
                        <input type="text" maxlength="1" oninput="moveToNextInput(3)" />
                        <h2> &nbsp; _ &nbsp;</h2>
                        <input type="text" maxlength="1" oninput="moveToNextInput(4)" /> &nbsp;
                        <input type="text" maxlength="1" oninput="moveToNextInput(5)" /> &nbsp;
                        <input type="text" maxlength="1" oninput="moveToNextInput(6)" />
                    </div>
                    <br />

                    <div class="input-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <input type="submit" name="submit" value="Verify" />
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

    <!-- [ Script Start] -->
    <script>
        function moveToNextInput(currentIndex) {
            const nextIndex = currentIndex + 1;
            const prevIndex = currentIndex - 1;

            // If the user pressed backspace, focus on the previous input
            if (event.inputType === 'deleteContentBackward' && prevIndex >= 1) {
                const prevInput = document.querySelector(`.otp-input input:nth-child(${prevIndex})`);
                if (prevInput) {
                    prevInput.focus();
                    return;
                }
            }

            // If the user pressed any other key, focus on the next input
            const nextInput = document.querySelector(`.otp-input input:nth-child(${nextIndex})`);
            if (nextInput) {
                nextInput.focus();
            }
        }
    </script>
    <!-- [ Script End] -->

</body>

</html>