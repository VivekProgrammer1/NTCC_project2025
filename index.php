<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lost & Found - Home</title>
  <link rel="stylesheet" href="style.css">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif;}
    body { background:#f4f7fa; color:#333; transition: margin-left 0.3s ease;}

    .sidebar {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 2000;
      top: 0;
      left: 0;
      background-color: #2c3e50;
      overflow-x: hidden;
      transition: 0.3s;
      padding-top: 60px;
    }
    .sidebar a {
      padding: 15px 30px;
      text-decoration: none;
      font-size: 1.2rem;
      color: #fff;
      display: block;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background: #1abc9c;
      color: #fff;
      padding-left: 40px;
    }
    .sidebar .closebtn {
      position: absolute;
      top: 15px;
      right: 25px;
      font-size: 2rem;
      margin-left: 50px;
      color: white;
      cursor: pointer;
    }

    .openbtn {
      font-size: 1.5rem;
      cursor: pointer;
      background-color: #2c3e50;
      color: white;
      padding: 10px 15px;
      border: none;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 2100;
      border-radius: 5px;
      transition: 0.3s;
    }
    .openbtn:hover { background-color: #1abc9c; }

    /* Auth Buttons / Profile */
    .auth-buttons {
      position: fixed;
      top: 15px;
      right: 20px;
      z-index: 2100;
      display: flex;
      gap: 10px;
    }
    .auth-buttons a {
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      font-weight: bold;
      transition: 0.3s;
    }
    .signin { background:#2c3e50; color:white; }
    .signup { background:#1abc9c; color:white; }
    .signin:hover { background:#1abc9c; }
    .signup:hover { background:#16a085; }

    .profile-btn {
      background:#1abc9c;
      color:white;
      padding:8px 15px;
      font-weight:bold;
      border-radius:5px;
      cursor:pointer;
      text-decoration:none;
    }
    .profile-btn:hover {
      background:#16a085;
    }

    #home {
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      height:100vh;
      text-align:center;
      padding:20px;
      background: linear-gradient(135deg,#2c3e50,#4ca1af);
    }

    #home .university {
      display:flex;
      align-items:center;
      gap:15px;
      margin-bottom:20px;
    }
    #home .university img { width:80px; border-radius:10px; }
    #home .university h2 {
      font-size:5rem;
      color:white;
      font-weight:bold;
    }

    #home h1 { font-size:3rem; margin-bottom:15px; color:white;}
    #home p { font-size:1.3rem; margin-bottom:40px; color:white;}

    .tabs { display:flex; flex-wrap:wrap; gap:25px; justify-content:center;}
    .tab {
      width:200px; height:200px; border-radius:20px;
      display:flex; flex-direction:column; justify-content:center; align-items:center;
      text-align:center; font-size:1.2rem; font-weight:bold; color:white;
      cursor:pointer; transition:0.4s;
      box-shadow:0 8px 20px rgba(0,0,0,0.3);
      background: linear-gradient(135deg, #1abc9c, #16a085);
    }
    .tab:hover { transform: translateY(-10px) scale(1.05); }

    footer { text-align:center; padding:20px; background:#2c3e50; color:white; }
  </style>
</head>
<body>

  <!-- Hamburger -->
  <button class="openbtn" onclick="openNav()">☰ Menu</button>

  <!-- TOP RIGHT -->
  <div class="auth-buttons">

    <?php if(isset($_SESSION['username'])): ?>
        <!-- USER LOGGED IN -->
        <a href="profile.php" class="profile-btn">
            👤 <?php echo $_SESSION['username']; ?>
        </a>

    <?php else: ?>
        <!-- USER NOT LOGGED IN -->
        <a href="login_Page/sign_In.php" class="signin">Sign In</a>
        <a href="login_Page/Sign_Up.php" class="signup">Sign Up</a>
    <?php endif; ?>

  </div>

  <!-- Sidebar -->
  <div id="mySidebar" class="sidebar">
    <span class="closebtn" onclick="closeNav()">×</span>
    <a href="index.php">Home</a>
    <a href="lost.html">Lost</a>
    <a href="found.html">Found</a>
    <a href="about.html">About</a>
  </div>

  <section id="home">
    <div class="university">
      <img src="amity.logo.jpeg" alt="Amity University Patna Logo">
      <h2>Amity University Patna</h2>
    </div>

    <h1>Welcome to Lost & Found Portal</h1>
    <p>Quickly navigate to report lost items, found items, or learn more about us.</p>

    <div class="tabs">
      <div class="tab" onclick="location.href='lost.html'">Report Lost Item</div>
      <div class="tab" onclick="location.href='found.html'">Report Found Item</div>
      <div class="tab" onclick="location.href='about.html'">About Us</div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Lost & Found Website | NTCC Project</p>
  </footer>

  <script>
    function openNav(){ document.getElementById("mySidebar").style.width="250px"; }
    function closeNav(){ document.getElementById("mySidebar").style.width="0"; }
  </script>

</body>
</html>
