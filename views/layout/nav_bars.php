<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <h3>Navbar</h3>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['username'])) {
        echo "Navbar: User is logged in";
    } else {
        echo "Navbar: User is not logged in";
    }
    ?>