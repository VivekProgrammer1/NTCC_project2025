<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "sign_up_system");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_no = trim($_POST['phone_no']);
    $enrollment_no = trim($_POST['enrollment_no']);
    $password_input = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password_input !== $confirm_password) {
        $message = "❌ Passwords do not match!";
    } else {
        $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE email=? OR enrollment_no=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $enrollment_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "❌ Email or Enrollment No. already registered!";
        } else {
            $insert_sql = "INSERT INTO users (name, email, phone_no, enrollment_no, password) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sssss", $name, $email, $phone_no, $enrollment_no, $hashed_password);

            if ($insert_stmt->execute()) {
                // ✅ Signup successful → Set session to auto-login
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;

                header("Location: ../index.php"); // redirect to home page
                exit;
            } else {
                $message = "❌ Insert Error: " . $conn->error;
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<link rel="stylesheet" href="sign_up.css">
<style>
.message { text-align:center; font-weight:bold; margin-bottom:15px; }
.message.success { color:green; }
.message.error { color:red; }
</style>
</head>
<body>
<div class="container">
    <div class="signup-box">
        <h2 class="signup-title">Sign Up</h2>

        <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && $message != ""): ?>
        <div class="message <?php echo strpos($message,'✅')!==false?'success':'error'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label>Full Name</label>
                <input name="name" type="text" placeholder="Enter your full name" value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input name="email" type="email" placeholder="Enter your email" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>" required>
            </div>
            <div class="input-group">
                <label>Phone No.</label>
                <input name="phone_no" type="tel" placeholder="Enter your Phone No." value="<?php echo isset($_POST['phone_no'])?htmlspecialchars($_POST['phone_no']):''; ?>" required>
            </div>
            <div class="input-group">
                <label>Enrollment No.</label>
                <input name="enrollment_no" type="text" placeholder="Enter your college Enrollment No." value="<?php echo isset($_POST['enrollment_no'])?htmlspecialchars($_POST['enrollment_no']):''; ?>" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <div class="terms">
                <input type="checkbox" name="checkbox" required>
                <span>I agree to the <a href="term_and_condition">Terms & Conditions</a></span>
            </div>
            <button name="submit" type="submit">Sign Up</button>
        </form>
        <p style="text-align:center; margin-top:15px;">Already have an account? <a href="sign_In.php" style="color red;">Sign In</a></p>
    </div>
</div>
</body>
</html>
