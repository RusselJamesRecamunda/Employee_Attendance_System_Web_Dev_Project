<?php
// Create a connection to the database
$conn = mysqli_connect("localhost", "root", "", "block_3c");

// Check for connection errors
if (!$conn) {
   $error_msg = mysqli_error($conn);
   exit($error_msg);
}

?>