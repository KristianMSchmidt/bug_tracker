<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');
if (!isset($_GET['order'])) {
    $_GET['order'] = 'full_name';
    $_GET['dir'] = 'desc';
}
$contr = new controller;
$users = $contr->get_all_users_details($_GET['order'], $_GET['dir']);
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="users_overview">
            <div class="wrapper">
                <div class="card w3-responsive">
                    <div class="w3-container card-head">
                        <h3>Users Overview</h3>
                    </div>
                    <div class="w3-container">
                        <p>All users in the database</p>
                    </div>
                    <div class="w3-container w3-responsive">
                        <table class="w3-table w3-small w3-striped w3-bordered">
                            <tr>
                                <th><a href="#" onclick="reorder('users_overview', 'full_name','<?php echo $_GET['dir'] ?>')">Name</a></th>
                                <th>Email</th>
                                <th><a href="#" onclick="reorder('users_overview', 'role_name','<?php echo $_GET['dir'] ?>')">Role</a></th>
                                <th class="hide_last"><a href="#" onclick="reorder('users_overview', 'created_at','<?php echo $_GET['dir'] ?>')">Created</a></th>
                                <th class="hide_if_needed"><a href="#" onclick="reorder('users_overview', 'updated_at','<?php echo $_GET['dir'] ?>')">Last Update</a></th>
                                <th>User Details</th>
                            </tr>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user['full_name'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['role_name'] ?></td>
                                    <td class="hide_last"><?php echo $user['created_at'] ?></th>
                                    <td class="hide_if_needed"><?php echo $user['updated_at'] ?></td>
                                    <td><a href="user_details.php?user_id=<?php echo $user['user_id'] ?>">Details</a></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                        <?php if (count($users) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no users in the database</p>
                            </div>
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Only administrator and project managers have access to this page.</p>
    <?php endif ?>
</div>

<?php require_once('page_frame/closing_tags.php') ?>

<script>
    set_active_link("users_overview")
</script>