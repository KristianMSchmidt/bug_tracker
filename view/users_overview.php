<?php
require('../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');

$contr = new controller;
$users = $contr->get_users("all_users");
?>

<div class="main">
    <div class="users">
        <div class="wrapper">
            <div class="card w3-responsive">
                <div class="w3-container card-head">
                    <h3>Users Overview</h3>
                </div>
                <div class="w3-container">
                    <p>All users in the database</p>
                </div>
                <div class="w3-container w3-responsive card-content">
                    <table class="table w3-small striped bordered">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="hide_if_needed">Last Update</th>
                            <th class="hide_if_needed">Updated By</th>
                        </tr>
                        <?php
                        //$users = array();
                        ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user['full_name'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $user['role_name'] ?></td>
                                <td class="hide_last"><?php echo $user['created_at'] ?></th>
                                <td class="hide_if_needed"><?php echo $user['updated_at'] ?></td>
                                <td class="hide_if_needed"><?php echo $user['updated_by'] ?></td>
                                <td>
                                    <a href="user_details.php?user_id=<?php echo $user['user_id'] ?>">Details</a>
                                </td>
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
</div>

<?php require_once('page_frame/closing_tags.php') ?>

<script>
    set_active_link("users_overview")
</script>

<?php
require('../control/shared/clean_session.inc.php');
?>