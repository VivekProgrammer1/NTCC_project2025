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

// Check if user is coming from OTP verification
if(!isset($_SESSION['otp_email'])){
    header("Location: forgot_pass.php");
    exit;
}

if(isset($_POST['reset_password'])){
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['otp_email'];

    if($new_password === $confirm_password){
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed_password, $email);
        if($stmt->execute()){
            $message = "Password has been reset successfully!";
            // Clear session
            unset($_SESSION['otp']);
            unset($_SESSION['otp_email']);
        } else {
            $message = "Failed to reset password. Try again!";
        }
    } else {
        $message = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgot_pass.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-box">
            <h2>Reset Password</h2>
            <?php if($message != "") { echo "<p style='color:red;'>$message</p>"; } ?>
            <form method="post">
                <div class="input-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
            <div class="back-to-signin">
                <a href="sign_In.php">Back to Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
