<?php
session_start();

// PHPMailer include
require '../PHPmailer/PHPMailer.php';
require '../PHPmailer/SMTP.php';
require '../PHPmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ntcc_project"; // apna database name
$conn = new mysqli("localhost", "root", "", "sign_in_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if(isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    // Check if email exists in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $otp = rand(100000,999999); // 6 digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kuttapilla37@gmail.com'; // apna Gmail
            $mail->Password = 'gste valf uual ajzs';    // app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('kuttapilla37@gmail.com', 'Lost & Found');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'OTP for Password Reset';
            $mail->Body    = "<h3>Your OTP is: <b>$otp</b></h3>";

            $mail->send();
            $message = "OTP has been sent to your email.";
            header("Location: verify_otp.php"); // OTP verify page
            exit;
        } catch (Exception $e) {
            $message = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Email not found in our records!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgot_pass.css">
</head>
<body>
    <div class="container">
        <div class="forgot-password-box">
            <h2>Forgot Password</h2>
            <p>Enter your Email and we'll send you an OTP to reset your password.</p>
            <?php if($message != "") { echo "<p style='color:red;'>$message</p>"; } ?>
            <form method="post">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your Email" required>
                </div>
                <button type="submit" name="send_otp">Send OTP</button>
            </form>
            <div class="anotherway">
                <a href="Another_way_to_sign_in.html">Another way to forget your password.</a>
            </div>
            <div class="back-to-signin">
                <a href="sign_In.php">Back to Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
