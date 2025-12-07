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

    /* Sidebar */
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

    /* Hamburger Button */
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

    /* Auth / Profile */
    .auth-buttons, .profile-dropdown {
      position: fixed;
      top: 15px;
      right: 20px;
      z-index: 2100;
      display: flex;
      gap: 10px;
    }
    .auth-buttons a, .profile-dropdown button {
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      font-weight: bold;
      transition: 0.3s;
      border: none;
      cursor: pointer;
    }
    .auth-buttons .signin { background: #2c3e50; color: #fff; }
    .auth-buttons .signin:hover { background: #1abc9c; }
    .auth-buttons .signup { background: #1abc9c; color: #fff; }
    .auth-buttons .signup:hover { background: #16a085; }

    .profile-dropdown button {
      background: #2c3e50; color: #fff;
      position: relative;
    }
    .profile-dropdown button:hover { background: #1abc9c; }

    .profile-dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      z-index: 2200;
      border-radius: 5px;
      overflow: hidden;
    }
    .profile-dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    .profile-dropdown-content a:hover { background-color: #ddd; }

    .profile-dropdown:hover .profile-dropdown-content { display: block; }

    /* Home Full Screen */
    #home {
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      height:100vh;
      text-align:center;
      padding:20px;
      background: linear-gradient(135deg,#2c3e50,#4ca1af);
      transition: margin-left 0.3s ease;
    }

    #home .university {
      display:flex;
      align-items:center;
      gap:15px;
      margin-bottom:20px;
      animation: pulse 2s infinite;
    }
    #home .university img {
      width:80px; height:auto;
      border-radius:10px;
      animation: pulse 2s infinite;
    }
    #home .university h2 {
      font-size:5rem;
      color:white;
      font-weight:bold;
      background: linear-gradient(90deg, #1abc9c, #16a085, #f39c12, #e74c3c);
      -webkit-background-clip:text; 
      -webkit-text-fill-color: transparent;
      animation: gradientMove 4s ease infinite;
    }

    #home h1 { font-size:3rem; margin-bottom:15px; color:white; animation: fadeInDown 1s ease forwards;}
    #home p { font-size:1.3rem; margin-bottom:40px; color:white; animation: fadeInUp 1s ease forwards;}

    /* Tabs / Cards */
    .tabs { display:flex; flex-wrap:wrap; gap:25px; justify-content:center;}
    .tab {
      width:200px; height:200px; border-radius:20px;
      display:flex; flex-direction:column; justify-content:center; align-items:center;
      text-align:center; font-size:1.2rem; font-weight:bold; color:white;
      cursor:pointer; transition:0.4s; box-shadow:0 8px 20px rgba(0,0,0,0.3);
      background: linear-gradient(135deg, #1abc9c, #16a085);
      position:relative;
    }
    .tab:hover {
      transform: translateY(-10px) scale(1.05);
      box-shadow:0 12px 25px rgba(0,0,0,0.4);
    }
    .tab i { font-size:2.5rem; margin-bottom:10px; }

    /* Footer */
    footer { text-align:center; padding:20px; background:#2c3e50; color:white; }

    /* Animations */
    @keyframes fadeInDown {0% {opacity:0; transform:translateY(-50px);} 100% {opacity:1; transform:translateY(0);} }
    @keyframes fadeInUp {0% {opacity:0; transform:translateY(50px);} 100% {opacity:1; transform:translateY(0);} }
    @keyframes pulse {0%, 100% { transform: scale(1);} 50% { transform: scale(1.05);} }
    @keyframes gradientMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

    /* Responsive */
    @media(max-width:768px){
      .tabs { flex-direction:column; align-items:center;}
      .tab { width:80%; height:150px; }
      #home .university h2 { font-size:3rem; }
    }
  </style>
</head>
<body>

  <!-- Hamburger Button -->
  <button class="openbtn" onclick="openNav()">☰ Menu</button>

  <!-- Sign In / Sign Up OR Profile Dropdown -->
  <?php if(isset($_SESSION['user_name'])): ?>
    <div class="profile-dropdown">
      <button><?php echo $_SESSION['user_name']; ?> ▼</button>
      <div class="profile-dropdown-content">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  <?php else: ?>
    <div class="auth-buttons">
      <a href="login_Page/sign_In.php" class="signin">Sign In</a>
      <a href="login_Page/Sign_Up.php" class="signup">Sign Up</a>
    </div>
  <?php endif; ?>

  <!-- Sidebar -->
  <div id="mySidebar" class="sidebar">
    <span class="closebtn" onclick="closeNav()">×</span>
    <a href="index.php">Home</a>
    <a href="lost.html">Lost</a>
    <a href="found.html">Found</a>
    <a href="about.html">About</a>
  </div>

  <!-- Home Section -->
  <section id="home">
    <div class="university">
      <img src="amity.logo.jpeg" alt="Amity University Patna Logo">
      <h2>Amity University Patna</h2>
    </div>
    <h1>Welcome to Lost & Found Portal</h1>
    <p>Quickly navigate to report lost items, found items, or learn more about us.</p>

    <div class="tabs">
      <div class="tab" onclick="location.href='lost.html'">
        <i class="fas fa-search"></i>
        Report Lost Item
      </div>
      <div class="tab" onclick="location.href='found.html'">
        <i class="fas fa-hand-paper"></i>
        Report Found Item
      </div>
      <div class="tab" onclick="location.href='about.html'">
        <i class="fas fa-info-circle"></i>
        About Us
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Lost & Found Website | NTCC Project</p>
  </footer>

  <script>
    function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
      document.body.style.marginLeft = "250px";
    }

    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
      document.body.style.marginLeft = "0";
    }
  </script>
</body>
</html>
