<?php
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchDate = mysqli_real_escape_string($conn, $_POST['daily']);
    $formattedSearchDate = DateTime::createFromFormat('d - m - Y', $searchDate)->format('d - m - Y');
    
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_late, atlog.am_undertime, atlog.pm_late, atlog.pm_undertime, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id
            WHERE DATE_FORMAT(atlog.atlog_date, '%d - %m - %Y') = '$formattedSearchDate' AND 
            (atlog.am_late != 0 OR atlog.am_undertime != 0 OR atlog.pm_late != 0 OR atlog.pm_undertime != 0)";
    $searchSubmitted = true;
} else {
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_late, atlog.am_undertime, atlog.pm_late, atlog.pm_undertime, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id
            WHERE atlog.am_late != 0 OR atlog.am_undertime != 0 OR atlog.pm_late != 0 OR atlog.pm_undertime != 0";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Daily Attendance</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <!-- DATE-PICKER -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
   <style>
    #btn_undo {
    cursor: pointer;
    font-weight: 700;
    font-family: Helvetica,"sans-serif";
    transition: all .2s;
    padding: 10px 20px;
    border-radius: 100px;
    background: white;
    border: 1px solid transparent;
    display: flex;
    align-items: center;
    font-size: 15px;
  }
  
  #btn_undo:hover {
    background: white;
  }
  
  #btn_undo > #arrow  {
    width: 34px;
    margin-left: 3px;
    transition: transform .3s ease-in-out;
  }
  
  #btn_undo:hover #arrow {
    transform: translateX(5px);
  }
  
  #btn_undo:active {
    transform: scale(0.95);
  }
  
  
   </style>

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
        <h1>Enter Day of Attendance
          <div class="form-row">
            <div class="form-holder">
              <div class="input-with-icon">
                <span class="material-symbols-outlined">today</span>
                <form method="post" action="">
                  <input type="text" class="form-control datepicker-here" data-language='en' data-date-format="dd - mm - yyyy" id="daily_atdnc" name="daily" placeholder="Select Date Attendance" required>
                  <button type="submit" class="btn search-btn">Search</button>
                </form>
              </div>
            </div>
          </div> 
        </h1>
        <i class="fas fa-user-cog"></i>
      </div>

      <section class="attendance">
        <div class="attendance-list">
          <h1>Daily Attendance List</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>AM Late</th>
                <th>AM Undertime</th>
                <th>PM Late</th>
                <th>PM Undertime</th>
                <th>Date</th>
                <th>Work Status</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      $fullName = $row["first_name"] . ' ' . $row["last_name"];
                      echo "<tr>
                          <td>" . $row["emp_id"] . "</td>
                          <td>" . $fullName . "</td>
                          <td>" . $row["am_late"] . ' Minutes' . "</td>
                          <td>" . $row["am_undertime"] . ' Minutes' . "</td>
                          <td>" . $row["pm_late"] . ' Minutes' . "</td>
                          <td>" . $row["pm_undertime"] . ' Minutes' . "</td>
                          <td>" . $row["atlog_date"]  . "</td>
                          <td>" . $row["work_status"] . "</td>
                      </tr>";
                  }
              }

              // If the form has been submitted, display a Back button
              if ($searchSubmitted) {
                  echo '<tr><td colspan="10">
                  <center><button class="btn back-btn" 
                  style="background-color: #e44453; 
                  color: #fff;
                  font-weight: bold;
                  margin-top: 10px;" onclick="redirectTo(\'other_daily.php\')">
                  <span class="material-symbols-outlined">undo
                  </span>Go Back</button></center></td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <br>
        <center><button id="btn_undo" onclick="redirectTo('daily.php')">
        <span class="material-symbols-outlined" id="arrow">arrow_back_ios</span><span>Back to Attendance</span>
        </button></center>
      </section>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- DATE-PICKER -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $(document).ready(function () {
      // Initialize datepicker
      $('#daily_atdnc').datepicker({
          format: 'dd- mm - yyyy', // Specify your desired date format
          autoclose: true
      });
    });
  </script>

  <script>
    function redirectTo(url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
