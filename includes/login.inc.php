<?php

if (!isset($_POST['login_submit'])) {
    header('Location: ..views/login.php');
    exit();
} else {
    require "db_connect.inc.php";

    $user_login = $_POST['user_login']; //either username or email
    $password = $_POST['password'];

    if (empty($user_login) || empty($password)) {
        //error message: Fill in all fields
        header('Location: ../views/login.php?error=emptyfields');
        exit();
    } else {
        require "db_connect.inc.php";

        $user_login = mysqli_real_escape_string($conn, $user_login);
        $password = mysqli_real_escape_string($conn, $password);
        //prepared statements is a better way to protect database than mysqli_real_escape_string
        //https://www.youtube.com/watch?v=I4JYwRIjX6c

        $sql =
            "SELECT * 
             FROM users JOIN user_roles
             ON users.role_id = user_roles.role_id 
             WHERE (username ='$user_login' OR email='$user_login')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            //error message: A database error occured
            header('Location: ../views/login.php?error=db_error');
            exit();
        } elseif (mysqli_num_rows($result) == 0) {
            // user_login is not in database
            //error message: Invalid username or password
            header('Location: ../views/login.php?error=invalid');
            exit();
        } else {
            // fetch result in array format
            $user = mysqli_fetch_assoc($result);

            // the (hashed) password
            $password_db =  $user['password'];

            //does the entered password match the hashed password in the database?;
            $psw_check = password_verify($password, $password_db); //boolean

            if ($psw_check == false) {
                // wrong password
                //error message: Invalid username or password
                header('Location: ../views/login.php?error=invalid');
                exit();
            } else {
                // login is succesfull
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_name'] = $user['role_name'];
                header('Location: ../views/dashboard.php?login=succes');
                exit();
            }
        }

        //free result from memory (supposed to be good practice, but does it matter here? a lot of confusion about this)
        mysqli_free_result($result);

        // close connection
        mysqli_close($conn);
    }
}
