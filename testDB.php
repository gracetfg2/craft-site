<?php

$servername = "arsun2.web.engr.illinois.edu";
$username = "arsun2_1";
$password = "craft123";
$dbname = "arsun2_craft";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else {
    echo "Connection Successful";
}
mysqli_close($conn);
?>
