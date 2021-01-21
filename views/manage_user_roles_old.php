<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
$contr = new controller;

if (isset($_POST['assign_role_submit'])) {
    //print_r($_POST);
    /*
    $no_selected_role_error = "";
    $no_selected_users_error = "";
    if (!isset($POST['new_role'])) {
        $no_selected_role_error = "No new role selected";
    }
    if (!isset($POST['user_ids'])) {
        $no_selected_users_error = "Select one or more users";
    }*/

    $new_role = $_POST['new_role'];
    $selected_users = explode(" ", trim($_POST['user_ids']));
    //print_r($selected_users);
    //exit();

    foreach ($selected_users as $user_id) {
        $contr->set_role(trim($user_id), $new_role);
    }
}
$users = $contr->get_users();

?>

<div class="main" style="background-color:#f9f9f9">
    <div class="manage_user_roles">
        <?php if (isset($_POST['assign_role_submit'])) : ?>
            <?php $num_changed = 0 ?>
            <div class="card">
                <div class="container card-head">
                    <h3>Changed User Roles</h3>
                </div>
                <div class="container">
                    <p>
                        You succesfully updated the role of the following users
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
            <br>
        <?php else : ?>
            <div class="row">
                <div class="col">
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


                <div class="col flex-2">
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
            var selected_users_str = ""
            selected_users.forEach(user_id => {
                selected_users_str += " " + user_id;
            });
            document.getElementById("input_user_ids").value = selected_users_str;
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
                document.getElementById("no_selected_role").innerHTML = "Select New role";
                errors = true;
            } else {
                document.getElementById("no_selected_role").innerHTML = "";
            };
            if (!errors) {
                document.getElementById("assign_role_submit").value = "submited";
                document.getElementById("assign_role_form").submit();
            }
        }
    </script>

    <?php include('shared/closing_tags.php') ?>
    <script>
        set_active_link("manage_user_roles");
    </script>