<?php
// Database connection
$host = "localhost";
$dbname = "block_3c";
$username = "root";
$password = "";
$employeeName = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function getEmployeeName($pdo, $employeeId)
    {
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM employee WHERE emp_id = ?");
        $stmt->execute([$employeeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['first_name'] . ' ' . $result['last_name'];
        } else {
            return false;
        }
    }
    function updateAtlogRecord($pdo, $employeeId, $atlogDate, $amIn, $amOut, $pmIn, $pmOut)
    
{
    // Check if a record already exists for the specified employee and date
    $stmtExists = $pdo->prepare("SELECT COUNT(*) FROM atlog WHERE emp_id = ? AND atlog_date = ?");
    $stmtExists->execute([$employeeId, $atlogDate]);
    $recordCount = $stmtExists->fetchColumn();

    // Calculate late minutes if AM In time is past 7 AM
    $amInLateMinutes = 0;
    $amInTime = DateTime::createFromFormat('H:i', $amIn);
    $amInLimitTime = DateTime::createFromFormat('H:i', '08:00');

    if ($amInTime && $amInTime > $amInLimitTime) {
        $interval = $amInTime->diff($amInLimitTime);
        $amInLateMinutes = $interval->format('%i');
    }

    // Calculate undertime minutes if AM Out time is before 12 PM
    $amOutUndertimeMinutes = 0;
    $amOutTime = DateTime::createFromFormat('H:i', $amOut);
    $amOutLimitTime = DateTime::createFromFormat('H:i', '12:00');

    if ($amOutTime && $amOutTime < $amOutLimitTime) {
        $interval = $amOutLimitTime->diff($amOutTime);
        $amOutUndertimeMinutes = $interval->format('%i');
    }

    // Calculate late minutes if PM In time is past 1 PM
    $pmInLateMinutes = 0;
    $pmInTime = DateTime::createFromFormat('H:i', $pmIn);
    $pmInLimitTime = DateTime::createFromFormat('H:i', '13:00');

    if ($pmInTime && $pmInTime > $pmInLimitTime) {
        $interval = $pmInTime->diff($pmInLimitTime);
        $pmInLateMinutes = $interval->format('%i');
    }

    // Calculate undertime minutes if PM Out time is before 7 PM
    $pmOutUndertimeMinutes = 0;
    $pmOutTime = DateTime::createFromFormat('H:i', $pmOut);
    $pmOutLimitTime = DateTime::createFromFormat('H:i', '19:00');

    if ($pmOutTime && $pmOutTime < $pmOutLimitTime) {
        $interval = $pmOutLimitTime->diff($pmOutTime);
        $pmOutUndertimeMinutes = $interval->format('%i');
    }

    if ($recordCount > 0) {
        // Get the existing record
        $stmtSelect = $pdo->prepare("SELECT * FROM atlog WHERE emp_id = ? AND atlog_date = ?");
        $stmtSelect->execute([$employeeId, $atlogDate]);
        $existingData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Update the existing record
        $stmtUpdate = $pdo->prepare("
            UPDATE atlog 
            SET am_in = COALESCE(?, am_in),
                am_out = COALESCE(?, am_out),
                pm_in = COALESCE(?, pm_in),
                pm_out = COALESCE(?, pm_out),
                am_late = COALESCE(?, am_late),
                am_undertime = COALESCE(?, am_undertime),
                pm_late = COALESCE(?, pm_late),
                pm_undertime = COALESCE(?, pm_undertime)
            WHERE emp_id = ? AND atlog_date = ?
        ");
        $stmtUpdate->execute([
            $amIn ?: $existingData['am_in'],
            $amOut ?: $existingData['am_out'],
            $pmIn ?: $existingData['pm_in'],
            $pmOut ?: $existingData['pm_out'],
            $amInLateMinutes ?: $existingData['am_late'],
            $amOutUndertimeMinutes ?: $existingData['am_undertime'],
            $pmInLateMinutes ?: $existingData['pm_late'],
            $pmOutUndertimeMinutes ?: $existingData['pm_undertime'],
            $employeeId,
            $atlogDate
        ]);
    } else {
        // Insert a new record
        $stmtInsert = $pdo->prepare("
            INSERT INTO atlog (emp_id, atlog_date, am_in, am_out, pm_in, pm_out, am_late, am_undertime, pm_late, pm_undertime)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtInsert->execute([$employeeId, $atlogDate, $amIn, $amOut, $pmIn, $pmOut, $amInLateMinutes, $amOutUndertimeMinutes, $pmInLateMinutes, $pmOutUndertimeMinutes]);
    }
}

       


      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search_submit'])) {
          $employeeId = $_POST['employee_id'];
          $employeeName = getEmployeeName($pdo, $employeeId);
      } elseif (isset($_POST['am_in_submit']) || isset($_POST['am_out_submit']) || isset($_POST['pm_in_submit']) || isset($_POST['pm_out_submit'])) {
          $employeeId = $_POST['employee_id'];
          $atlogDate = $_POST['atlog_date'];
          $amIn = $_POST['am_in'] ?? null;
          $amOut = $_POST['am_out'] ?? null;
          $pmIn = $_POST['pm_in'] ?? null;
          $pmOut = $_POST['pm_out'] ?? null;
          updateAtlogRecord($pdo, $employeeId, $atlogDate, $amIn, $amOut, $pmIn, $pmOut);
        }
      }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Management System</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="css/empAtt.css">
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

    <div class="wrapper">
    <form method="post" action="">
            	<div id="wizard">
	                <h4>Employee Attendance</h4>
	                <section>
	                	<div class="form-header">
                          <div class="avartar">
                            <img id="avatar-image" src="images/OIP.jpg" alt="">
                              <div class="avartar-picker">
                                <label for="file-input">
                                 <i class="zmdi zmdi-camera"></i>
                               <span>Choose Picture</span>
                              </label>
                             <input type="file" name="file-1[]" id="file-input" class="inputfile" data-multiple-caption="{count} files selected" multiple onchange="displayImage(this)">
                              </div>
                              </div>

							<div class="form-group">
								<div class="form-holder">
									<label for="employee_id">Employee ID:</label><br>
                                       <input type="text" id="employee_id" name="employee_id" value="<?php echo isset($_POST['employee_id']) ? $_POST['employee_id'] : ''; ?>" required><br><br>
                                       <input type="submit" id="att_submit" name="search_submit" value="Search"><br><br>
                                
                                <label for="name">Full Name</label><br>
                                <input class="form-control" value="<?php echo $employeeName; ?>"><br>
                                
                                <label for="atlog_date">Set Date</label><br>
									<input type="date" id="atlog_date" class="form-control" name="atlog_date" >
								</div>
							</div>
	                	</div>
	                	<div class="form-holder">
							<label for="am_in">AM In:</label><br>
            				<input type="time" id="am_in" name="am_in" class="form-control"><br><br>
            				<input type="submit" id="att_submit" name="am_in_submit" value="Update AM In">
						</div>
						<div class="form-holder">
							<label for="am_out">AM Out:</label><br>
							<input type="time" id="am_out" name="am_out" class="form-control"><br><br>
							<input type="submit" id="att_submit" name="am_out_submit" value="Update AM Out">
						</div>
						<div class="form-holder">
							<label for="pm_in">PM In:</label><br>
            				<input type="time" id="pm_in" name="pm_in" class="form-control"><br><br>
            				<input type="submit" id="att_submit" name="pm_in_submit" value="Update PM In">
						</div>
						<div class="form-holder">
							<label for="pm_out">PM Out:</label><br>
            				<input type="time" id="pm_out" name="pm_out" class="form-control"><br><br>
            				<input type="submit" id="att_submit" name="pm_out_submit" value="Update PM Out">
						</div>
	                </section>
		</div>
    </form>
	</div>
</div>
</body>

<script>
    function displayImage(input) {
      var file = input.files[0];

      if (file) {
        var reader = new FileReader();

        reader.onload = function (e) {
          document.getElementById('avatar-image').src = e.target.result;
        };

        reader.readAsDataURL(file);
      }
    }
  </script>
</html>

