<div class="main"">
    <h2>Login Create a new user</h2>
    <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

    <label>Username: </label>
    <input type="text" name="username" value="<?php echo $_POST['username'] ?? '' ?>">
    <div class="error">
        <?php echo $form_errors['username'] ?? '' ?>
    </div>
    <label>Password: </label>
    <input type="text" name="pwd" value="">
    <div class="error">
        <?php echo $form_errors['pwd'] ?? '' ?>
    </div>
    <input type="submit" value="submit" name="login_submit">

    </form>
</div>