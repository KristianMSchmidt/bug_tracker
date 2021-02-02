<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
$contr = new controller;

if (isset($_POST['assign_role_submit'])) {
    $selected_users = json_decode($_POST['user_ids']);
    $new_role = $contr->get_role_name_by_role_id($_POST['new_role']);
    foreach ($selected_users as $user_id) {
        $contr->set_role(trim($user_id),  $_POST['new_role']);
        $message = "updated your role to '{$new_role['role_name']}'";
        $contr->create_notification(1, $user_id, $message, $_SESSION['user_id']);
    }
}

/* Converting PHP array into js-object. I don't use this yet, but will later */
$users = $contr->get_users();
$json =  json_encode($users);
echo "
<script>
        var users_js = {$json};
        console.log(users_js)
</script>";


?>

<div class="new_main">

    <h1>Manage User Roles</h1>
    <div class="container">
        <div class="manage_user_roles">

            <div class="area_one">
                
                <h4>Select One or more Users </h4>
                <div class="scroll">
                    <?php foreach ($users as $user) : ?>
                        <?php $demo_users = array("Demo Admin", "Demo PM", "Demo Dev", "Demo Sub") ?>
                        <?php if (!in_array($user['full_name'], $demo_users)) : ?>
                            <p id="<?php echo $user['user_id'] ?>" onclick="toggle_user(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] ?></p>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <p id="no_selected_users" class="error"></p>

                <h4>Select the Role to Assign</h4>
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
                <p id="no_selected_role" class="error"></p>

                <input type="submit" value="Submit" class="btn-primary" onclick="submit_form()">
            </div>

            <div class="area_two">
                <div class="card">
                    <div class="container card-head">
                        <h3>Your Personnel</h3>
                    </div>
                    <div class="container">
                        <h5>
                            All users in your database
                            <!--
                            <form action="" method="post">
                                Show <input type="number" name="show_count" value="10" class="show_count"> Entries
                            </form>
                            -->
                        </h5>
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
                        <?php if (count($users) == 0) : ?>
                            <div class="empty-table-row">
                            <p>You have no projects in the database</p>
                            </div>
                            <p style="font-size:12px">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p style="font-size:12px">Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

     <!-- Model response message -->
     <?php if (isset($_POST['assign_role_submit'])) : ?>
        <?php $num_changed = 0 ?>
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container">
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <div class="container">
                        <p>
                            You succesfully updated the following users
                        </p>
                        <div class="container w3-responsive">
                            <table class="table striped bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>New Role</th>
                                </tr>
                                <?php foreach ($selected_users as $user_id) : ?>
                                    <?php $user = $contr->get_user_by_id($user_id);
                                    $num_changed += 1 ?>
                                    <tr>
                                        <td><?php echo $user['full_name'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['role_name'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <p>Showing 1-<?php echo $num_changed; ?> of <?php echo $num_changed; ?> entries</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('id01').style.display = 'block';
        </script>
    <?php endif ?>
</div>
<script>
    var selected_users = [];

    function toggle_user(user_id) {
        //document.getElementById(user_id).classList.toggle("active");
        if (!document.getElementById(user_id).classList.contains("active")) {
            document.getElementById(user_id).classList.add("active");
            selected_users.push(user_id);
        } else {
            document.getElementById(user_id).classList.remove("active");
            selected_users = selected_users.filter(function(value, index, arr) {
                return value != user_id;
            })
        }
    }

    function submit_form() {
        var errors = false;
        if (selected_users.length == 0) {
            document.getElementById("no_selected_users").innerHTML = "Select one or more Users";
            errors = true;
        } else {
            document.getElementById("no_selected_users").innerHTML = "";
        }
        if (document.getElementById("selected_role").value == "") {
            document.getElementById("no_selected_role").innerHTML = "Select new Role";
            errors = true;
        } else {
            document.getElementById("no_selected_role").innerHTML = "";
        };
        if (!errors) {
            document.getElementById("input_user_ids").value = JSON.stringify(selected_users);
            document.getElementById("assign_role_submit").value = "submited";
            document.getElementById("assign_role_form").submit();
        }
    }
</script>
</div>
<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("manage_user_roles");
</script>