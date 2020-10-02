<?php

if(!isset($_POST['signup_submit'])){
    header('Location: ../login.php');
    exit();//make sure that code below does not get executed when we redirect
}


require "db_connect.inc.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];


if(empty($username) || empty($email) || empty($password) || empty($password_repeat)){
    //error message: Fill in all fields
    header("Location: ../signup.php?error=emptyfields&username={$username}&email={$email}");
    exit();
}

else if(!preg_match('/^\w{5,}$/', $username)) {
    // error message: Invalid username  (must be alphanumeric & longer than or equals 5 chars)   
    header("Location: ../signup.php?error=invalidusername&username=&email={$email}");
    exit();
    }
    
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //error message: Email address is not valid. 
    header("Location: ../signup.php?error=invalidmail&username={$username}&email=");     
    exit();            
}

else if(!preg_match('/^\w{5,}$/', $password)) { 
    // error message: invalid password(alphanumeric & longer than or equals 5 chars)
    header("Location: ../signup.php?error=invalidpsw&username={$username}&email={$email}");     
    exit();            
}
 
else if($password !== $password_repeat){
    // error message: The two password have to match
    header("Location: ../signup.php?error=pwsrepeat&username={$username}&email={$email}");     
    exit();            
}

else{

    //Lets check if username is already in database    
    $sql = "SELECT * FROM users WHERE username ='$username'"; 
    //The above is unsafe: Hackers could put sql-code into username-search field that would destroy database.
    //mysqli_real_escape_string is about formatting, not security. The correct way of making security is using prepared statemends
    //Se 1:30 herhttps://www.youtube.com/watch?v=LC9GaXkdxF8

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        //error message: A database error occured
        header("Location: ../signup.php?error=db_error&username={$username}&email={$email}");     
        exit();
    }

    else if (mysqli_num_rows($result) > 0) {
        //error message: username already taken
        header("Location: ../signup.php?error=usernametaken&username=&email={$email}");     
        exit();
    }

    //Lets check if email is already in database    
    $sql = "SELECT * FROM users WHERE email ='$email'"; 
    //The above is unsafe: Hackers could put sql-code into username-search field that would destroy database.
    //mysqli_real_escape_string is about formatting, not security. The correct way of making security is using prepared statemends
    //Se 1:30 herhttps://www.youtube.com/watch?v=LC9GaXkdxF8

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        //error message: A database error occured
        header("Location: ../signup.php?error=db_error&username=&email={$email}");     
        exit();
    }

    else if (mysqli_num_rows($result) > 0) {
        //error message: email already in db
        header("Location: ../signup.php?error=mailtaken&username={$username}&email=");     
        exit();
    }

    
    // There are no errors and user can be registered in database

    // escape sql chars
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    //$password = mysqli_real_escape_string($conn, $passw);  //should I do this??
    $hashed_password =password_hash($password, PASSWORD_DEFAULT); //safety


    // create sql    
    $sql = "INSERT INTO users(username, email, password) VALUES('$username','$email','$hashed_password')";

    // save to db and check
    if(mysqli_query($conn, $sql)){
        // success
        header('Location: ../login.php?signedup=succes');
        exit();
    } 
    else{
        //database error
        header("Location: ../signup.php?error=db_error&username={$username}&email={$email}");     
        //echo('query error: '. mysqli_error($conn));
        exit();
    }
}

// free result from memory (good practice)
mysqli_free_result($result);

// close connection
mysqli_close($conn);