<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Navbar</h3>
    <?php
    print_r($_SESSION);
    if (isset($_SESSION['username'])) {
        echo "Navbar: User is logged in";
    } else {
        echo "Navbar: User is not logged in";
    }
    ?>