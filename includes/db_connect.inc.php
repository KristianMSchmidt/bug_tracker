<?php
// connect to database
$conn = mysqli_connect('localhost', 'kimarokko', 'stjerne', 'test');

// check connection 
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
    exit();
}
