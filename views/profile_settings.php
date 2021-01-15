<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
?>

<div class="main">
    <div class="profile_settings">
        <div class="card">
            <div class="container lightgrey">
                <h4>Profile Settings</h4>
            </div>
            <div class="container">
                <table>
                    <tr>
                        <td>Full name:</td>
                        <td><?php echo $_SESSION['full_name'] ?></td>
                    </tr>

                    <tr>
                        <td>User ID:</td>
                        <td><?php echo $_SESSION['user_id'] ?></td>
                    </tr>
                    <tr>
                        <td>Current Role:</td>
                        <td><?php echo $_SESSION['role_name'] ?></td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td><?php echo $_SESSION['user_email'] ?></td>
                    </tr>
                </table>
            </div>
            <br>
        </div>
        <div class="card">
            <div class="container lightgrey">
                <h4>Privileges</h4>
            </div>
            <div class="container">
                <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                    <p style="max-width:400px;">As administrator you can do almost anything on this site. <br> <br>If you are a guest, feel free to delete, create and edit: I have a back-up of the database and do daily resets.</p>
                <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                    <p>As project manager you can assign users to projects and create tickets</p>
                <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                    <p>As developer you can change the status of tickets </p>
                <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                    <p>As submitter you can create new tickets to projects </p>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('shared/closing_tags.php') ?>