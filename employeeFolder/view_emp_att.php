<?php
// Database connection
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = mysqli_real_escape_string($conn, $_POST['emp_id']);
    
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id
            WHERE atlog.emp_id = '$empId'";
    $searchSubmitted = true;
} else {
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Attendance</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="css/search.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!-- DATE-PICKER -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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

    <section class="main">
      <div class="main-top">
        <h1>Search by Employee ID
          <div class="form-row">
            <div class="form-holder">
              <div class="input-with-icon">
                <form method="post" action="">
                  <input placeholder="Enter Employee ID" type="text" id="srch_id" name="emp_id" class="form-control" required>
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
          <h1>Employee Attendance List</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>AM In</th>
                <th>AM Out</th>
                <th>PM In</th>
                <th>PM Out</th>
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
                          <td>" . $row["am_in"] . "</td>
                          <td>" . $row["am_out"] . "</td>
                          <td>" . $row["pm_in"] . "</td>
                          <td>" . $row["pm_out"] . "</td>
                          <td>" . $row["atlog_date"] . "</td>
                          <td>" . $row["work_status"] . "</td>
                      </tr>";
                  }
              }

              // If the form has been submitted, display a Back button
              if ($searchSubmitted) {
                  echo '<tr><td colspan="8">
                  <center><button class="btn back-btn" 
                  style="background-color: #e44453; 
                  color: #fff;
                  font-weight: bold;
                  margin-top: 10px;" onclick="redirectTo(\'view_emp_att.php\')">
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
