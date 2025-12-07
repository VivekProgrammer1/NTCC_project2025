<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ntcc_project"; // apna database name
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if(isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $email = $_SESSION['otp_email'];

    if($entered_otp == $_SESSION['otp']){
        // OTP correct, redirect to reset password page
        header("Location: reset_password.php");
        exit;
    } else {
        $message = "Invalid OTP. Please try again!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="forgot_pass.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-box">
            <h2>Verify OTP</h2>
            <p>Enter the OTP sent to your email to reset your password.</p>
            <?php if($message != "") { echo "<p style='color:red;'>$message</p>"; } ?>
            <form method="post">
                <div class="input-group">
                    <label>OTP</label>
                    <input type="number" name="otp" placeholder="Enter OTP" required>
                </div>
                <button type="submit" name="verify_otp">Verify OTP</button>
            </form>
            <div class="back-to-signin">
                <a href="sign_In.php">Back to Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
