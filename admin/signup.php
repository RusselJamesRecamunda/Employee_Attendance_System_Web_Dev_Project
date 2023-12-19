<?php

// Establishing connection
include('connect.php');

try {
    // Validation of empty fields
    if (isset($_POST['register'])) {
        if (empty($_POST['u_email'])) {
            throw new Exception("Email cannot be empty.");
        }

        if (empty($_POST['u_name'])) {
            throw new Exception("Username cannot be empty.");
        }

        if (empty($_POST['pass'])) {
            throw new Exception("Password cannot be empty.");
        }

        if (empty($_POST['fname'])) {
            throw new Exception("Full name cannot be empty.");
        }

        if (empty($_POST['phone'])) {
            throw new Exception("Phone cannot be empty.");
        }

        if (empty($_POST['type'])) {
            throw new Exception("Type cannot be empty.");
        }

        // Check if the username already exists
        $check_username_stmt = $conn->prepare("SELECT COUNT(*) FROM admininfo WHERE username = ?");
        $check_username_stmt->bind_param("s", $_POST['u_name']);
        $check_username_stmt->execute();
        $check_username_stmt->bind_result($username_count);
        $check_username_stmt->fetch();
        $check_username_stmt->close();

        if ($username_count > 0) {
            throw new Exception("Username is already taken. Please choose a different username.");
        }

        // Insertion of data into the database table admininfo using prepared statements
        $stmt = $conn->prepare("INSERT INTO admininfo(username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $_POST['u_name'], $_POST['pass'], $_POST['u_email'], $_POST['fname'], $_POST['phone'], $_POST['type']);
        $stmt->execute();
        $success_msg = "Registered Successfully!";
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Welcome Admin</title>
      <link rel="stylesheet" href="../css/style.css" />
      <link rel="stylesheet" href="../css/user.css">
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
            <li><a href="schedule.php">
            <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">event_note</span>Schedule</span>
            </a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">query_stats</span>Reports</span>
                </a>
                <ul class="dropdown-menu">
                    <li> <a href="log_report.php"><span id="l_icon" class="material-symbols-outlined">input</span>Login Report</a></li>
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
    
            <li><a href="../logout.php" class="logout">
              <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">logout</span>Log out</span>
            </a></li>
          </ul>
        </nav>
    
        <div class="page-content">
          <div class="form-v5-content">
            <form class="form-detail" action="#" method="post">
              
            <h2>Register User Details</h2>
            <center> <?php if(isset($success_msg)) echo $success_msg;
                    if(isset($error_msg)) echo $error_msg; ?></center><br>

              <div class="form-row">
                <label for="fname">Full Name</label>
                <input type="text" name="fname" id="fname" class="input-text" placeholder="Full Name" required>
              </div>
      
              <div class="form-row">
                <label for="username">Username</label>
                <input type="text" name="u_name" id="username" class="input-text" placeholder="Username" required>
              </div>
      
              <div class="form-row">
                <label for="u_email">User Email</label>
                <input type="text" name="u_email" id="email" class="input-text" placeholder="Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
              </div>
      
              <div class="form-row">
                <label for="password">Password</label>
                <input type="password" name="pass" id="pass" class="input-text" placeholder="Password" required>
              </div>
      
              <div class="form-row">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="input-text" placeholder="Phone" required>
              </div>

              <!-- Add radio buttons here -->
              <center><div class="radio-inputs">
                <label class="radio">
                  <input type="radio" name="type" value="employee" checked="">
                  <span class="name">Employee</span>
                </label>
                <label class="radio">
                  <input type="radio" name="type" value="admin">
                  <span class="name">Admin</span>
                </label>
                </div></center>

              <div class="form-row-last">
                <button type="submit" name="register" class="register" style="height: 40px;">
                <span class="material-symbols-outlined">how_to_reg</span>Register User</button>
              </div>

              <center><button id="c_btn"><span>Add Employee Information</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 74 74" height="34" width="34">
            <circle stroke-width="3" stroke="black" r="35.5" cy="37" cx="37"></circle>
            <path fill="black" d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z"></path>
            </svg>
            </button></center>
            
            </form>

        

            <script>
            // Function to handle button click
            function redirectToEmpAdd() {
            window.location.href = "emp_add.php";
            }
            // Attach click event listener to the button with the specified ID
            document.getElementById("c_btn").addEventListener("click", redirectToEmpAdd);
            </script>


          </div>
          
        </div>

      </div>

      

      
     
    </body>
    </html>
