<?php
require 'templates/ui_frame.php';

if (!$_SESSION['role'] == '1') {
    //Only users logged in as admins will see this page
    header('Location: login.php');
    exit();
}

include('includes/db_connect.inc.php');

// write query for all users
$sql = 'SELECT * FROM users';

// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<div class="main">

    <h3> All users </h3>

    <table style="width:100%">
        <tr>
            <th>user_id</th>
            <th>username</th>
            <th>email</th>
            <th>role</th>
            <th>update role</th>
            <th>created_at</th>
            <th>last_update</th>
            <th>role updated by</th>
        </tr>

        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user['user_id'] ?></td>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $role_str[$user['role']] ?></td>
                <td>
                    <?php if (!($user['username'] == "Demo Admin" ||
                        $user['username'] == "Demo Project Manager" ||
                        $user['username'] == "Demo Developer" ||
                        $user['username'] == "Demo Submitter")) : ?>

                        <form action="includes/update_role.inc.php" method="POST">
                            <select name="<?php echo $user['username'] ?>">
                                <?php if ($user['role'] == '1') : ?>
                                    <option value=1 selected="selected">Admin</option>
                                    <option value=2>Project Manager</option>
                                    <option value=3>Developer</option>
                                <?php endif; ?>
                                <?php if ($user['role'] == '2') : ?>
                                    <option value=1>Admin</option>
                                    <option value=2 selected="selected">Project Manager</option>
                                    <option value=3>Developer</option>
                                <?php endif; ?>
                                <?php if ($user['role'] == '3') : ?>
                                    <option value=1>Admin</option>
                                    <option value=2>Project Manager</option>
                                    <option value=3 selected="selected">Developer</option>
                                <?php endif; ?>
                            </select>
                            <input type="submit" value="Update" name="update_role">
                        </form>
                    <?php endif; ?>
                </td>
                <td><?php echo $user['created_at'] ?></td>
                <td><?php echo $user['updated_at'] ?></td>
                <td><?php echo get_username($user['updated_by']) ?></td>

                <td>
                    <?php if (!($user['username'] == "Demo_Developer" ||
                        $user['username'] == "Demo_Admin" ||
                        $user['username'] == "Demo_Project_Manager")) : ?>
                        <form action="includes/delete_member.inc.php" method="POST">
                            <input type="hidden" name="delete_member_w_id" value="<?php echo $user['user_id'] ?>">
                            <input type="submit" value="Delete Member" name="delete_submit">
                        </form>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    // free result from memory (good practice)
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);
    ?>
</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>