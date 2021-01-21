<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
$contr = new controller;
$users = $contr->get_users();
?>


<div class="new_main">
    <div class="template">
        <div style="background-color:bisque; flex:1">
            <div>
                <h1>Manage User Roles</h1>
                <h4>Select One or more Users</h4>
                <div class="scroll">
                    <?php foreach ($users as $user) : ?>
                        <p id="<?php echo $user['user_id'] ?>" onclick="toggle_user(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] ?></p>
                    <?php endforeach ?>
                </div>
                <br>
                <p id="no_selected_users" class="error" style="margin:0; padding:0"></p>
                <h4>Select the Role to Assign</h4>
                <p id="no_selected_role" class="error" style="margin:0; padding:0"></p>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="assign_role_form">
                    <input type="hidden" name="user_ids" value="" id="input_user_ids">
                    <input type="hidden" name="new_role" value="">
                    <input type="hidden" name="assign_role_submit" value="" id="assign_role_submit">
                </form>

                <select class="select" name="new_role" form="assign_role_form" id="selected_role">
                    <option value="" disabled selected>-- Select Role --</option>
                    <option value="1">Admin</option>
                    <option value="2">Project Manager</option>
                    <option value="3">Developer</option>
                    <option value="4">Submitter</option>
                </select>

                <input type="button" value="Submit" class="btn-primary" onclick="submit_form()">
            </div>


        </div>

        <div style="background-color: greenyellow; flex:2">
            <div class="card">
                <div class="container card-head">
                    <h3>Your Personnel</h3>
                </div>
                <div class="container">
                    <p>
                        All users in your database
                    </p>
                    <div class="container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user['full_name'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['role_name'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <p>Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> entries</p>
                </div>
            </div>

        </div>
    </div>
</div>






<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("manage_user_roles");
</script>