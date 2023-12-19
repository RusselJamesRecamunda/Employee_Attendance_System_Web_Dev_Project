
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Attendance Details</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="../img/accountlogo.jpg">
          <span class="nav-item">Admin</span>
        </a></li>
        <li><a href="signup.php">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">account_circle</span>Create User</span>
        </a></li>
        <li><a href="#">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">chat</span>Message</span>
        </a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">query_stats</span>Login Report</span>
            </a>
            <ul class="dropdown-menu">
                <li> <a href="daily.php"><span id="l_icon" class="material-symbols-outlined">today</span>Daily Attendance</a></li>
              <li><a href="monthly.php"><span id="l_icon"class="material-symbols-outlined">calendar_month</span>Monthly Attendance</a></li>
            </ul>
          </li>

        <li><a href="../emp_view.php">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">database</span>Employee Data</span>
        </a></li>
        <li><a href="#">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">
            settings
            </span>Setting</span>
        </a></li>

        <li><a href="#" class="logout">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">logout</span>Log out</span>
        </a></li>
      </ul>
    </nav>


    </body>
</html>