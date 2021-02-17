<?php
require('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');

$contr = new Controller;
$users = $contr->get_users("all_users");

require('page_frame/ui_frame.php');
?>
<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin'])) : ?>
        <div class="manage_user_roles">
            <div class="wrapper">
                <!-- Select Users -->
                <div class="orto-wrapper left w3-container card non-table-card">
                    <h4>Select users </h4>
                    <div class="w3-container">
                        <input type="text" id="search_field" placeholder="Search name or role">
                        <p class="small-label">All users in your database</p>
                        <div class="scroll">
                            <?php foreach ($users as $user) : ?>
                                <p id="<?php echo $user['user_id'] ?>" class="searchable" onclick="toggle_user(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] . ' | ' . $user['role_name'] ?></p>
                            <?php endforeach ?>
                        </div>
                        <p id="no_selected_users" class="error"></p>
                    </div>
                </div>
                <!-- Selected Users -->
                <div class="orto-wrapper right card">
                    <div class="w3-container card-head">
                        <h4>Selected Users</h4>
                    </div>
                    <div class="w3-container">
                        <div class="w3-container">
                            <table class="table  w3-small bordered table-no-description">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th class="hide_if_needed">Created</th>
                                        <th>Last Update</th>
                                        <th>Updated By</th>
                                        <th>User Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr id="row_<?php echo $user['user_id'] ?>" style="display:none;">
                                            <td><?php echo $user['full_name'] ?></td>
                                            <td><?php echo $user['role_name'] ?></td>
                                            <td class="hide_if_needed"><?php echo $user['created_at'] ?></td>
                                            <td><?php echo $user['updated_at'] ?></td>
                                            <td>
                                                <?php if (isset($user['updated_by'])) : ?>
                                                    <?php echo $user['updated_by'] ?>
                                                <?php else : ?>
                                                    None
                                                <?php endif ?>
                                            </td>
                                            <td><a href="user_details.php?user_id=<?php echo $user['user_id'] ?>">Details</td>

                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <div id="no_selected_users_info" class="empty-table-row">
                                <p>No selected users</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="wrapper">
                <!-- Select Role -->
                <div class="orto-wrapper bottom left w3-container card non-table-card">
                    <h4>Select role to assign</h4>
                    <div class="w3-container">

                        <form action="../../control/manage_user_roles.inc.php" method="post" id="assign_role_form">
                            <input type="hidden" name="user_ids" value="" id="input_user_ids">
                            <input type="hidden" name="new_role" value="">
                            <input type="hidden" name="assign_role_submit" value="" id="assign_role_submit">
                        </form>

                        <select class="w3-select" name="new_role" form="assign_role_form" id="selected_role">
                            <option value="" disabled selected>Select Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Project Manager</option>
                            <option value="3">Developer</option>
                            <option value="4">Submitter</option>
                        </select>
                        <p id="no_selected_role" class="error"></p>
                    </div>


                </div>
                <div class="orto-wrapper bottom right w3-container card non-table-card">
                    <h4>Submit changes</h4>
                    <div class="w3-container">
                        <input type="submit" value="Submit" class="btn-primary" onclick="submit_form()">
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Only administrators and project managers have acces to this page. </p>
    <?php endif ?>
</div>

<?php if (isset($_SESSION['feedback_users'])) : ?>
    <!-- Modal response message -->
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Name</th>
                                <th>Old Role</th>
                                <th>Current Role</th>
                                <th>Role Changed</th>
                            </tr>
                            <?php foreach ($_SESSION['feedback_users'] as $feedback_user) : ?>
                                <tr>
                                    <td><?php echo $feedback_user['full_name'] ?></td>
                                    <td><?php echo $feedback_user['old_role_name'] ?></td>
                                    <td><?php echo $feedback_user['new_role_name'] ?></td>
                                    <td style="color:<?php echo $feedback_user['color'] ?>"><?php echo $feedback_user['message'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php $num_selected = count($_SESSION['feedback_users']); ?>
                    <p>Showing 1-<?php echo $num_selected; ?> of <?php echo $num_selected; ?> entries</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>

<script src="../js/manage_user_roles.js"></script>

<?php
require('page_frame/closing_tags.php');
?>

<script>
    set_active_link("manage_user_roles");
</script>