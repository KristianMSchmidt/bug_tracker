<?php

// Get acces to session variable
session_start();

// remove all session variables
session_unset();

// destroy the session 
session_destroy();

// redirect to login page
header('location: ../views/login.php?');
