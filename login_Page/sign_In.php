<?php
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "sign_in_system");

    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $phone_no = $_POST['phone_no'];
    $enrollment_no = $_POST['enrollment_no'];
    $password_input = $_POST['password'];
    $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE enrollment_no='$enrollment_no'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $message = "❌ This Enrollment No. is already registered!";
    } else {
        $sql = "INSERT INTO users (phone_no, enrollment_no, password) 
                VALUES ('$phone_no', '$enrollment_no', '$hashed_password')";
        $message = $conn->query($sql) === TRUE ? "✅ Signed in successfully!" : "❌ Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In</title>
<style>
body { margin:0; padding:0; font-family:Arial,sans-serif; background:linear-gradient(135deg,#2c3e50,#4ca1af); }
.container { display:flex; justify-content:center; align-items:center; height:100vh; }
.signin-box { background:#1abc9c;; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:350px; }
.signin-box h2 { text-align:center; margin-bottom:20px; }
.input-group { margin-bottom:15px; }
.input-group label { display:blocky; font-size:14px; margin-bottom:5px; }
.input-group input { width:100%; padding:10px; border:1px solid #ccc; border-radius:5px; font-size:14px; }
.options { display:flex; justify-content:space-between; align-items:center; font-size:12px; margin-bottom:15px; }
.options a { text-decoration:none; color:#007bff; }
button[type="submit"] { width:100%; padding:10px; background:linear-gradient(135deg, #0011ff, #ff00f7); color:#fff; font-size:16px; border:none; border-radius:5px; cursor:pointer; }
button[type="submit"]:hover { background:#0056b3; }
.message { text-align:center; font-weight:bold; margin-bottom:15px; }
.message.success { color:green; }
.message.error { color:red; }
</style>
</head>
<body>
<div class="container">
<div class="signin-box">
<h2>Sign In</h2>

<?php if($message != ""): ?>
<div class="message <?php echo strpos($message,'✅')!==false?'success':'error'; ?>">
<?php echo $message; ?>
</div>
<?php endif; ?>

<form method="POST" action="">
<div class="input-group">
<label>Phone No.</label>
<input type="tel" name="phone_no" placeholder="Enter your Phone No." required>
</div>
<div class="input-group">
<label>Enrollment No.</label>
<input type="text" name="enrollment_no" placeholder="Enter your college Enrollment No." required>
</div>
<div class="input-group">
<label>Password</label>
<input type="password" name="password" placeholder="Enter your password" required>
</div>
<div class="options">
<label><input type="checkbox"> Remember me</label>
<a href="forgot_pass.html">Forgot password?</a>
</div>
<button type="submit">Sign In</button>
</form>

</div>
</div>
</body>
</html>
