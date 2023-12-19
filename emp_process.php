<?php
// CREATING A CONNECTION TO THE DATABASE
include('connect.php');

// Initialize messages variables
$success_message = $error_message = '';

// FUNCTION FOR EDITING EMPLOYEE DATA
if (isset($_POST['edit'])) {
    try {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $work_status = $_POST['work_status'];
        $birthdate = $_POST['birthdate'];

        // IDENTIFYING THE EMPLOYEE ID THAT WILL BE EDITED IN THE DATABASE
        $employee_id = $_POST['employee_id'];

        $sql = "UPDATE employee SET 
            first_name = '$first_name',
            last_name = '$last_name',
            middle_name = '$middle_name',
            address = '$address',
            email = '$email',
            phone = '$phone',
            work_status = '$work_status',
            birthdate = '$birthdate'
            WHERE emp_id = $employee_id";

        if (mysqli_query($conn, $sql)) {
            $success_message = "Employee updated successfully";
        } else {
            throw new Exception("Error updating employee: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
// FETCHING THE PREVIOUS DATA IN THE DATABASE
if (isset($_GET['editid'])) {
    $e_id = $_GET['editid'];
    $fetch_sql = "SELECT * FROM employee WHERE emp_id = $e_id";
    $fetch_result = mysqli_query($conn, $fetch_sql);

    try {
        if ($fetch_result) {
            if (mysqli_num_rows($fetch_result) > 0) {
                $row = mysqli_fetch_assoc($fetch_result);
                $e_first_name = $row['first_name'];
                $e_last_name = $row['last_name'];
                $e_middle_name = $row['middle_name'];
                $e_address = $row['address'];
                $e_email = $row['email'];
                $e_phone = $row['phone'];
                $e_work_status = $row['work_status'];
                $e_birthdate = $row['birthdate'];
            } else {
                throw new Exception("No records found for the given employee ID");
            }
        } else {
            throw new Exception("Error fetching employee data: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
// FUNCTION FOR DELETING EMPLOYEE DATA
if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM `employee` WHERE emp_id = $id";
    $result = mysqli_query($conn, $sql);

    if($result){
        header('location:emp_view.php');
    } else {
        $error_msg = mysqli_error($conn);
        echo "Error deleting employee data: " . $error_msg;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Edit Employee</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/user.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.css">
		 <!-- DATE-PICKER -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <!-- STYLE CSS -->
		<link rel="stylesheet" href="admin/css/style.css">
        
        <style>
        #btn_bck {
            border: none;
            font-family: sans-serif;
            font-size: 20px;
            font-weight: bold;
            background: transparent;
            color: #34AF6D;
            border: solid 1px rgba(0, 107, 179, 0.2);
            padding: 15px;
            border-radius: 4px;
            transition-duration: 0.2s;
        }

        #btn_bck:before {
            content: '↩ ';
            opacity: 0;
            margin-left: -15px;
            transition-duration: 0.2s;
        }

        #btn_bck:hover:before {
            margin-left: 0px;
            opacity: 1;
        }

        #btn_bck:hover {
            color: black;
            background: rgba(0, 0, 0, 0.02);
            border: solid 1px gainsboro;
        }
        </style>
	</head>

	<body>
    <div class="container">
        <nav>
          <ul>
            <li><a href="#" class="logo">
              <img src="img/accountlogo.jpg">
              <span class="nav-item">Admin</span>
            </a></li>
            <li><a href="./admin/signup.php">
              <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">account_circle</span>Create User</span>
            </a></li>
            <li><a href="#">
              <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">chat</span>Message</span>
            </a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">query_stats</span>Reports</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="admin/log_report.php"><span id="l_icon" class="material-symbols-outlined">input</span>Login Report</a></li>
                    <li><a href="admin/daily.php"><span id="l_icon" class="material-symbols-outlined">today</span>Daily Attendance</a></li>
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
    
            <li><a href="#" class="logout">
              <span class="nav-item"><span id="nav_icon" class="material-symbols-outlined">logout</span>Log out</span>
            </a></li>
          </ul>
        </nav>

        <div><button id="btn_bck" onclick="redirectTo('emp_view.php')">Back</button></div>
        <div class="wrapper">
            
            <form method="post" action="emp_process.php" id="wizard">
            
        		<!-- SECTION 1 -->
                <h4></h4>
                <section>
                    <div class="inner">
                        <center><header>Edit Employee Information</header>
                            <?php 
                            if ($success_message !== '') {
                                echo '<div class="success-message">' . $success_message . '<span class="material-symbols-outlined">update</span>'. '</div>';
                            }
                            ?></center><br>

                    	<a href="#" class="avartar">
                    		<img src="img/avatar.png" alt="">
                    	</a>

                        <input type="hidden" name="employee_id" value="<?php echo $e_id; ?>">

                    	<div class="form-row form-group">
                            <div class="form-holder">
                                <input type="text" class="form-control" name="first_name" value="<?php echo isset($e_first_name) ? $e_first_name : ''; ?>" placeholder="First Name">
                            </div>

                            <div class="form-holder">
                                <input type="text" class="form-control" name="last_name" value="<?php echo isset($e_last_name) ? $e_last_name : ''; ?>" placeholder="Last Name">
                            </div>

                            <div class="form-holder">
                                <input type="text" class="form-control" name="middle_name" value="<?php echo isset($e_middle_name) ? $e_middle_name : ''; ?>" placeholder="Middle Name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-holder">
                                <input type="text" class="form-control" name="email" value="<?php echo isset($e_email) ? $e_email : ''; ?>" placeholder="Email">
                                <i class="zmdi zmdi-email small"></i>
                            </div>
                        </div>

                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" class="form-control" name="phone" value="<?php echo isset($e_phone) ? $e_phone : ''; ?>" placeholder="Phone">
                            <i class="zmdi zmdi-smartphone-android"></i>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" class="form-control" name="address" value="<?php echo isset($e_address) ? $e_address : ''; ?>" placeholder="Address">
                            <i class="zmdi zmdi-map small"></i>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" class="form-control datepicker-here" data-language='en' data-date-format="dd - mm - yyyy" id="dp1" 
                            name="birthdate" value="<?php echo isset($e_birthdate) ? $e_birthdate : ''; ?>" placeholder="Date of Birth"> 
                            <i class="zmdi zmdi-calendar small"></i>
                        </div>
                    </div>  


                    <div class="select">
                            <div class="form-holder">
                                <select class="form-control" id="c_options" name="work_status" value="<?php echo isset($e_work_status) ? $e_work_status : ''; ?>" placeholder="Work Status">
                                <option value="" selected disabled>Update Type of Work</option>
                                    <option value="Work From Home">Work From Home</option>
                                    <option value="Onsite Work">Onsite Work</option>
                                    <option value="Night Shift">Night Shift</option>
                                </select><i class="zmdi zmdi-caret-down small"></i>
                            </div>
                        </div>

                        <div class="actions">
                             <Center><button id="input_edit" class="btn btn-primary my-5" type="submit" name="edit">
                             <span><span class="material-symbols-outlined">update</span>Update Employee Data</span></button></Center>
                        </div>
                </section>
                

                </section>
            </form>
		</div>

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
        
        <script>
            function redirectTo(url) {
            window.location.href = url;
        }
        </script>
        
<script src="js/main.js"></script>
</body>
</html>



