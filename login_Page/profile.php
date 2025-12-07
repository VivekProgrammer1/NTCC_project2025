<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_name'])){
    header("Location: sign_In.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ntcc_project"; // apna database name
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_email = $_SESSION['user_email']; // session me email store hai login ke time
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo $_SESSION['user_name']; ?></title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }
        .profile-container h2 { margin-bottom: 20px; }
        .profile-container p { margin: 10px 0; font-size: 1.1rem; }
        .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Welcome, <?php echo $user['name']; ?></h2>
        <p><b>Email:</b> <?php echo $user['email']; ?></p>
        <p><b>Phone:</b> <?php echo $user['phone']; ?></p>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
