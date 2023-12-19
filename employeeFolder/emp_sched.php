<?php 
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Schedule</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
  <div class="container">
  <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="../img/accountlogo.jpg">
          <span class="nav-item">Employee</span>
        </a></li>
        <li><a href="addEmpAtt.php">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">co_present</span>Set Attendance</span>
        </a></li>
        <li><a href="emp_sched.php">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">event_available</span>Work Calendar</span>
        </a></li>

        <li><a href="view_emp_att.php">
        <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">preview</span>View Attendance</span>
        </a></li>

        <li><a href="#">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">
            settings
            </span>Setting</span>
        </a></li>

        <li><a href="../logout.php" class="logout">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">logout</span>Log out</span>
        </a></li>
      </ul>
    </nav>

    <!-- Embedded Google Calendar -->
    <iframe src="https://calendar.google.com/calendar/embed?height=1000&wkst=1&bgcolor=%239fda7a&ctz=UTC&title=EMPLOYEE%20WORK%20SCHEDULE&showTabs=1&showPrint=0&src=YzY4N2JmNDc0MDhmYzNiOTBlOTFkYWQ5MmQ1MDI0ZmNlMGMxYWU1NmY4ZTU1ZjM5M2E2YmUxNjRlNzU1ZjlkY0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%230B8043" style="border-width:0" width="1300" height="1000" frameborder="0" scrolling="no"></iframe>
    </body>
</html>
