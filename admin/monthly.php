<?php
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchMonth = mysqli_real_escape_string($conn, $_POST['monthly']);
    $formattedSearchMonth = DateTime::createFromFormat('m - Y', $searchMonth)->format('m - Y');

    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id
            WHERE DATE_FORMAT(atlog.atlog_date, '%m - %Y') = '$formattedSearchMonth'";
    $searchSubmitted = true;
    $result = mysqli_query($conn, $sql);
} else {
    // Display all data initially
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Monthly Attendance</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="css/download.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <!-- DATE-PICKER -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<style>
  #monthly_atdnc {
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
 
 #monthly_atdnc:focus {
   border-bottom: 2px solid #34AF6D;
   border-radius: 4px 4px 2px 2px;
 }
 
 #monthly_atdnc:hover {
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
                <li><a href="daily.php"><span id="l_icon" class="material-symbols-outlined">today</span>Daily Attendance</a></li>
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

    <section class="main">
      <div class="main-top">
        <h1>Enter Month of Attendance
          <div class="form-row">
            <div class="form-holder">
              <div class="input-with-icon">
                <span class="material-symbols-outlined">today</span>
                <form method="POST" action="">
                  <input type="text" class="form-control datepicker-here" data-language='en' data-date-format="mm - yyyy" id="monthly_atdnc" name="monthly" placeholder="Select Date Attendance" required>
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
          <h1>Monthly Attendance List</h1>
          <button type="button" class="buttonDownload" onclick="downloadCSV()">Download Monthly</button>
          <table class="table">
            <thead>
              <tr>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>AM In</th>
                <th>AM Out</th>
                <th>PM In</th>
                <th>PM Out</th>
                <th>Month Date</th>
                <th>Work Status</th>
              </tr>
            </thead>
            <?php if ($searchSubmitted): ?>
                <!-- Display data based on search -->
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['emp_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['am_in']; ?></td>
                            <td><?php echo $row['am_out']; ?></td>
                            <td><?php echo $row['pm_in']; ?></td>
                            <td><?php echo $row['pm_out']; ?></td>
                            <td><?php echo $row['atlog_date']; ?></td>
                            <td><?php echo $row['work_status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="10">
                            <center>
                                <button class="btn back-btn" style="background-color: #e44453; color: #fff; font-weight: bold; margin-top: 10px;" onclick="redirectTo('monthly.php')">
                                    <span class="material-symbols-outlined">undo</span> Go Back
                                </button>
                            </center>
                        </td>
                    </tr>
                </tbody>
            <?php else: ?>
                <!-- Display all data initially -->
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['emp_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['am_in']; ?></td>
                            <td><?php echo $row['am_out']; ?></td>
                            <td><?php echo $row['pm_in']; ?></td>
                            <td><?php echo $row['pm_out']; ?></td>
                            <td><?php echo $row['atlog_date']; ?></td>
                            <td><?php echo $row['work_status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            <?php endif; ?>
          </table>
        </div>
      </section>
    </section>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- DATE-PICKER -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="js/monthly.js"></script>
</body>
</html>
