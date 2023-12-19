<?php  
// Include database connection
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchDate = mysqli_real_escape_string($conn, $_POST['search_date']);
    $formattedSearchDate = DateTime::createFromFormat('d - m - Y', $searchDate)->format('d - m - Y');
    
    $sql = "SELECT user_id, full_name, login_date, login_time, logout_date, logout_time, status
            FROM log_report WHERE DATE_FORMAT(login_date, '%d - %m - %Y') = '$formattedSearchDate'";
    $searchSubmitted = true;
} else {
    $sql = "SELECT user_id, full_name, login_date, login_time, logout_date, logout_time, status FROM log_report";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login Report</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="css/download.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <!-- DATE-PICKER -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<style>
  #log_search {
  width: 200px;
   background-color: #f5f5f5;
   color: #242424;
   padding: .15rem .5rem;
   min-height: 40px;
   border-radius: 4px;
   outline: none;
   border: none;
   line-height: 1.15;
   box-shadow: 0px 10px 20px -18px;
 }
 
 #log_search:focus {
   border-bottom: 2px solid #34AF6D;
   border-radius: 4px 4px 2px 2px;
 }
 
 #log_search:hover {
   outline: 1px solid lightgrey;
 }
</style>
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
                <li><a href="log_report.php"><span id="l_icon" class="material-symbols-outlined">input</span>Login Report</a></li>
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

    <section class="main">
        <div class="main-top">
            <h1>Enter Date of Login</h1>
        </div>

        <div class="form-row">
            <div class="form-holder">
            <div class="input-with-icon">
            <span class="material-symbols-outlined">today</span>
            <form method="post" action="">
                <input type="text" class="form-control datepicker-here" data-language='en' data-date-format="dd - mm - yyyy" id="log_search" name="search_date" placeholder="Select Date" required>
                <button type="submit" class="btn search-btn" name="search">Search</button>
            </form>
            </div>
            </div>
        </div>

      <section class="attendance">
        <div class="attendance-list">
          <h1>Login Report List</h1>
          <!-- Add a new button for CSV download -->
          <button class="buttonDownload" onclick="downloadCSV()">Download Log Report</button>
          <table class="table">
            <thead>
              <tr>
                <th>User ID</th>
                <th>User Full Name</th>
                <th>Login Date</th>
                <th>Login Time</th>
                <th>Logout Date</th>
                <th>Logout Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $row["user_id"] . "</td>
                            <td>" . $row["full_name"] . "</td>
                            <td>" . $row["login_date"] . "</td>
                            <td>" . $row["login_time"] . "</td>
                            <td>" . $row["logout_date"] . "</td>
                            <td>" . $row["logout_time"] . "</td>
                            <td>" . $row["status"] . "</td>
                        </tr>";
                    }
                }

                // If the form has been submitted, display a Back button
                if ($searchSubmitted) {
                    echo '<tr><td colspan="7">
                    <center><button class="btn back-btn" 
                    style="background-color: #e44453; 
                    color: #fff;
                    font-weight: bold;
                    margin-top: 10px;" onclick="redirectTo(\'log_report.php\')">
                    <span class="material-symbols-outlined">undo
                    </span>Go Back</button></center></td></tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
      </section>
    </section>
  </div>

   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DATE-PICKER -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="js/log_report.js"></script>
    
</body>
</html>
