<?php
// Set default value for $_SESSION['name']
$_SESSION['name'] = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// CREATING A CONNECTION TO THE DATABASE
include('connect.php');

// Initialize messages variables
$success_message = $error_message = '';

// Check if the user is not on emp_add.php
if ($_SESSION['name'] != 'oasis' && basename($_SERVER['PHP_SELF']) != 'emp_add.php') {
    header('location: emp_add.php');
    exit();
}

// FUNCTION FOR ADDING EMPLOYEE DATA
if (isset($_POST['add'])) {
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $work_status = isset($_POST['work_status']) ? $_POST['work_status'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO employee(first_name, last_name, middle_name, address, email, phone, work_status, birthdate, emp_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Use try-catch block for error handling
    try {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $first_name, $last_name, $middle_name, $address, $email, $phone, $work_status, $birthdate, $emp_pic);

        // Handle image upload
        if (isset($_FILES["image"])) {
            $file = $_FILES["image"];
            $fileTmpName = $file["tmp_name"];
            $fileError = $file["error"];

            // Ensure the "uploads" directory exists
            $uploadsDirectory = 'uploads/';
            if (!file_exists($uploadsDirectory)) {
                mkdir($uploadsDirectory, 0755, true);
            }

            if ($fileError === 0) {
                $originalFileName = $file["name"];
                $uploadPath = $uploadsDirectory . $originalFileName;
                move_uploaded_file($fileTmpName, $uploadPath);

                // Set the image path in the SQL query
                $emp_pic = $originalFileName;
            } else {
                $error_message = "Error uploading image: " . $fileError;
                // Stop execution if there is an error in image upload
                throw new Exception($error_message);
            }
        } else {
            $emp_pic = ''; // If no image is uploaded, set an empty string
        }

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Employee added successfully";
        } else {
            $error_message = "Error adding employee: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        $error_message = "Exception: " . $e->getMessage();
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Add Employee</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/user.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <!-- DATE-PICKER -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
    <div class="container">
        <nav>
          <ul>
            <li><a href="#" class="logo">
              <img src="../img/accountlogo.jpg">
              <span class="nav-item">Admin</span>
            </a></li>
            <li><a href="#">
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

        <div class="wrapper">
          <form method="post" id="wizard" enctype="multipart/form-data">
        		<!-- SECTION 1 -->
                <h4></h4>
                <section>
                    <div class="inner">
                        <center><header>Add Employee Information</header></center><br>
                        <center><?php
                        // Display success message if set
                        if (!empty($success_message)) {
                            echo '<div class="success-message">' . $success_message . '<span class="material-symbols-outlined">
                            task_alt
                            </span>'. '</div>';
                        }

                        // Display error message if set
                        if (!empty($error_message)) {
                            echo '<div class="error-message">' . $error_message . '<span class="material-symbols-outlined">
                            cancel
                            </span>'.'</div>';
                        }
                        ?></center>

                      <br><br><br>
                    	<div class="form-row form-group">
                    		<div class="form-holder">
                    			<input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                    		</div>
                    		<div class="form-holder">
                    			<input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                    		</div>
                            <div class="form-holder">
                    			<input type="text" class="form-control" name="middle_name" placeholder="Middle Name" required>
                    		</div>
                    	</div>
                    	
                    	<div class="form-row">
                    		<div class="form-holder">
                    			<input type="text" class="form-control" name="email" placeholder="Email" required>
                    			<i class="zmdi zmdi-email small"></i>
                    		</div>
                    	</div>

                    	<div class="form-row">
                    		<div class="form-holder">
                    			<input type="text" class="form-control" name="phone" placeholder="Phone" required>
                    			<i class="zmdi zmdi-smartphone-android"></i>
                    		</div>
                    	</div>
                    	<div class="form-row">
                    		<div class="form-holder">
                    			<input type="text" class="form-control" name="address" placeholder="Address" required>
                                <i class="zmdi zmdi-map small"></i>
                    		</div>
                    	</div>


                        <div class="form-row">
                            <div class="form-holder">
                                <input type="text" class="form-control datepicker-here" data-language='en' data-date-format="dd - mm - yyyy" id="dp1" name="birthdate" placeholder="Date of Birth" required> 
                                <i class="zmdi zmdi-calendar small"></i>
                            </div>
                        </div>  
                        
                        <div class="form-row">
                            <div class="select">
                                <div class="form-holder">
                                    <select class="form-control" id="c_options" name="work_status" placeholder="Type of Work" required>
                                        <option value="" selected disabled>Select Type of Work</option>
                                        <option value="Work From Home">Work From Home</option>
                                        <option value="Onsite Work">Onsite Work</option>
                                        <option value="Night Shift">Night Shift</option>
                                    </select><i class="zmdi zmdi-caret-down small"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-holder">
                            <label for="image">Upload Employee Profile:</label>
                            <input type="file" name="image" accept="image/*" id="image" required>
                          </div>
                        </div>
                        <div class="actions">
                     <Center><button id="btn_add" class="btn btn-primary my-5" type="submit" name="add">
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                          </svg>Add Employee Data</span>
                        </button></Center>
                    </div>

    
                    </div>
                </section>

            </form>
		</div>


        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- DATE-PICKER -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

        <script>
            $(document).ready(function () {
            // Initialize datepicker
            $('#dp1').datepicker({
            format: 'dd - mm - yyyy', // Specify your desired date format
            autoclose: true
            });
        });
        </script>

        <script src="js/main.js"></script>

      </div>
	
</body>
</html>