<?php  
//STEP 1
include 'connect.php';

$searchSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchId = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT emp_id, first_name, last_name, middle_name, address, email, phone, work_status, birthdate
            FROM `employee` WHERE emp_id = '$searchId'";
    $searchSubmitted = true;
} else {
    $sql = "SELECT emp_id, first_name, last_name, middle_name, address, email, phone, work_status, birthdate
            FROM `employee`";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Data</title>
  <link rel="stylesheet" href="css/view.css" />
  <link rel="stylesheet" href="admin/css/download.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="./img/accountlogo.jpg">
          <span class="nav-item">Admin</span>
        </a></li>
        <li><a href="./admin/signup.php">
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
            <li> <a href="admin/log_report.php"><span id="l_icon" class="material-symbols-outlined">input</span>Login Report</a></li>
                <li> <a href="admin/daily.php"><span id="l_icon" class="material-symbols-outlined">today</span>Daily Attendance</a></li>
              <li><a href="admin/monthly.php"><span id="l_icon"class="material-symbols-outlined">calendar_month</span>Monthly Attendance</a></li>
            </ul>
          </li>

        <li><a href="emp_view.php">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">database</span>Employee Data</span>
        </a></li>
        <li><a href="#">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">
            settings
            </span>Setting</span>
        </a></li>

        <li><a href="login.php" class="logout">
          <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">logout</span>Log out</span>
        </a></li>
      </ul>
    </nav>


    <section class="main">
          <section class="search centered-search">
            <form method="post" class="search-form">
              <header><strong>Search Employee</strong></header>
              <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                <g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 
                3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 
                7.5-7.5-3.365-7.5-7.5z"></path></g>
              </svg>
                  <input type="text" id="search" name="search" placeholder="Enter Employee ID">
                  <button type="submit" class="btn search-btn">Search</button>
            </form>
          </section>
          

      <section class="attendance">
        <div class="attendance-list">
          <h1>Employee Information</h1>
          <button type="button" class="buttonDownload" onclick="downloadCSV()">Download Emp Data</button>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Emp ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Address</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Work Status</th>
                <th scope="col">Birthday</th>
                <th scope="col">Operations</th>  
              </tr>
            </thead>

            <tbody>

    <!-- PHP FUNCTION TO FETCH THE EMPLOYEE DATA IN THE DATABASE AND DISPLAY THE EMPLOYMENT LIST -->
    <?php
              if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      $id = $row['emp_id'];
                      $first_name = $row['first_name'];
                      $last_name = $row['last_name'];
                      $middle_name = $row['middle_name'];
                      $address = $row['address'];
                      $email = $row['email'];
                      $phone = $row['phone'];
                      $work_status = $row['work_status'];
                      $birthdate = $row['birthdate'];

                      echo '<tr>
                          <th scope="row">' . $id . '</th>
                          <td>' . $first_name . '</td>
                          <td>' . $last_name . '</td>
                          <td>' . $middle_name . '</td>
                          <td>' . $address . '</td>
                          <td>' . $email . '</td>
                          <td>' . $phone . '</td>
                          <td>' . $work_status . '</td>
                          <td>' . $birthdate . '</td>
                          <td>
                              <button class="btn custom-btn" style="background-color: #52e974; color: #fff;" onclick="redirectTo(\'emp_process.php?editid=' . $id . '\')">Update</button>
                              <button class="btn custom-btn" style="background-color: #e44453; color: #fff;" onclick="redirectTo(\'emp_process.php?deleteid=' . $id . '\')">Delete</button>
                          </td>
                      </tr>';
                  }
              }

              // If the form has been submitted, display a Back button
              if ($searchSubmitted) {
                  echo '<tr><td colspan="10">
                  <button class="btn back-btn" 
                  style="background-color: #e44453; 
                  color: #fff;
                  font-weight: bold;
                  margin-top: 10px;" onclick="redirectTo(\'emp_view.php\')">
                  <span class="material-symbols-outlined">undo
                  </span>Go Back</button></td></tr>';
              }
              ?>

            </tbody>

          </table>
        </div>
      </section>
    </section>
  </div>

  <script src="view.js" ></script>
</body>
</html>
