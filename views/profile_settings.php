<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
?>

<div class="main">
    <h2>Profile settings </h2>

    <table>
        <tr>
            <th>User ID</th>
            <th>Username </th>
            <th>Email</th>
            <th>Current role</th>
        </tr>
        <tr>
            <td><?php echo $_SESSION['user_id'] ?></td>
            <td><?php echo $_SESSION['username'] ?></td>
            <td><?php echo $_SESSION['user_email'] ?></td>
            <td><?php echo $_SESSION['role_name'] ?></td>
        </tr>
    </table>
    <br>
    <h3>Privileges</h3>
    <?php if ($_SESSION['role_name'] == 'Admin') : ?>
        <p>As <b>administrator</b> you can do almost everything on this site</p>
    <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
        <p>As <b>project manager</b> you can assign users to projects and create tickets</p>
    <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
        <p>As <b>developer</b> you can change the status of tickets </p>
    <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
        <p>As <b>submitter</b> you can create new tickets to projects </p>
    <?php endif ?>
</div>

<?php include('shared/closing_tags.php') ?>