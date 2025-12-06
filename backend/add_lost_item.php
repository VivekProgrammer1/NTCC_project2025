<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "lost_found_system");

    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>
                alert('❌ You must be logged in to report a lost item!');
                window.location.href = '../login_Page/Sign_In.html';
              </script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $date = $_POST['date'];

    $sql = "INSERT INTO lost_items (title, description, location, date, user_id)
            VALUES ('$title', '$description', '$location', '$date', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Lost item reported successfully!');
                window.location.href = '../lost.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error: " . $conn->error . "');
                window.location.href = '../lost.html';
              </script>";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
