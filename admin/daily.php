<?php
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchDate = mysqli_real_escape_string($conn, $_POST['daily']);
    $formattedSearchDate = DateTime::createFromFormat('d - m - Y', $searchDate)->format('d - m - Y');
    
    $sql = "SELECT atlog.emp_id, emp.first_name, emp.last_name, emp.work_status, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.atlog_date
            FROM atlog
            JOIN employee AS emp ON atlog.emp_id = emp.emp_id
            WHERE DATE_FORMAT(atlog.atlog_date, '%d - %m - %Y') = '$formattedSearchDate'";
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
  <title>Daily Attendance</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="css/daily.css">
  <link rel="stylesheet" href="css/download.css">
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
          <button type="button" class="buttonDownload" onclick="downloadCSV()">Download Daily</button>
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
                  echo '<tr><td colspan="10">
                  <center><button class="btn back-btn" 
                  style="background-color: #e44453; 
                  color: #fff;
                  font-weight: bold;
                  margin-top: 10px;" onclick="redirectTo(\'daily.php\')">
                  <span class="material-symbols-outlined">undo
                  </span>Go Back</button></center></td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <br>
        <center><button id="btn_more" onclick="redirectTo('other_daily.php')">
          <span>Continue</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 74 74" height="34" width="34">
              <circle stroke-width="3" stroke="black" r="35.5" cy="37" cx="37"></circle>
              <path fill="black" d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z"></path>
            </svg>
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

    function downloadCSV() {
        var csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Emp ID,Employee Name,AM In,AM Out,PM In,PM Out,Date,Work Status\n";

        // Extract data from the displayed table
        var table = document.querySelector('.table');
        var rows = table.querySelectorAll('tbody tr');

        rows.forEach(function(row) {
            var columns = row.querySelectorAll('td');
            var rowData = Array.from(columns).map(function(column) {
                return column.textContent;
            });
            csvContent += rowData.join(',') + '\n';
        });

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "daily_attendance.csv");
        document.body.appendChild(link);

        link.click(); // This will trigger the download
    }
  </script>
</body>
</html>
