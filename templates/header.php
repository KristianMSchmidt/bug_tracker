<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .loginerror{
            color:red
        }

        .loginsucces{
            color: lightgreen
        }
        
        .button_that_looks_like_link {
            background: none!important;
            border: none;
            padding: 0!important;
            /*optional*/
            font-family: arial, sans-serif;
            /*input has OS specific font-family*/
            color: #069;
            text-decoration: underline;
            cursor: pointer;
        }
        nav ul{
            height:100px; 
            background-color: lightgrey;
            width:18%;
            overflow:hidden; 
            overflow-y:scroll;
        }
        
    </style>
</head>
<body>

<?php
    session_start(); //this will start/resume session on all scripts with this header
?>

<?php if(isset($_SESSION['username'])): ?> 
       <!-- if user is logged in -->
    <?php require 'includes/tools.inc.php'; ?>

    <p>Username: <?php echo $_SESSION['username'];?> 
     . Role: <?php echo $role_str[$_SESSION['role']]; ?>. </p>
    <form action='includes/logout.inc.php' type = 'POST' style="display:inline-block">
    <input type="submit" name="logout_submit" value="LOG OUT">
    </form><br><br>   

    <form action='dashboard.php' style="display:inline-block">
        <input type="submit" value="MAIN PAGE">
    </form><br>   
    <p>-------------------------------------------------------------------------------</p>

<?php endif; ?>