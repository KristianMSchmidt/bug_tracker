<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$projects = $contr->get_projects();

if (isset($_POST['enroll_users_submit'])) {
    $selected_users = json_decode($_POST['user_ids']);
    $project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
    $notification_message = "enrolled you to the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->assign_to_project($user_id, $_POST['project_id']);
        $contr->create_notification(4, $user_id, $notification_message, $_SESSION['user_id']);
    }
}

if (isset($_POST['disenroll_users_submit'])) {
    $selected_users = json_decode($_POST['user_ids']);
    $project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
    $notification_message = "disenrolled your from the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->unassign_from_project($user_id, $_POST['project_id']);
        $contr->create_notification(5, $user_id, $notification_message, $_SESSION['user_id']);
    }
}

if (isset($_POST['project_id'])) {
    $project_users = $contr->get_project_users($_POST['project_id']);
    $non_project_users = $contr->get_users_not_enrolled_in_project($_POST['project_id']);
    $project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
}
?>

<div class="main">

    <div class="w3-container">
        <div class="manage_project_users">

            <h1>Manage Project Users</h1>

            <div class="orto-wrapper top w3-container card">
                <?php if (isset($_POST['project_id'])) : ?>

                    <div style="padding-right:1em; padding-top:1em;">
                        <h4 style="display:inline"><span style="color:grey;">Selected Project:</span> <?php echo $project_name ?></h4>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="select_other_form"></form>

                        <form action='project_details.php' method='post' id="project_details_form">
                            <input type="hidden" name="project_id" value="<?php echo $_POST['project_id'] ?>">
                            <input type="hidden" name="requested_action">
                        </form>
                        <br>
                        <div>
                            <a href="#" onclick="document.getElementById('select_other_form').submit()">Change Project</a>
                            <a href="#" style="float:right" onclick="document.getElementById('project_details_form').submit()">Project Details</a>
                        </div>
                    </div>

                <?php else : ?>
                    <h4>Select Project</h4>
                    <div class="w3-container">
                        <p>What project to assign users to?</p>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="project_form">
                            <select class="select w3-light-grey" name="project_id">
                                <?php foreach ($projects as $project) : ?>
                                    <?php if ($project['project_id'] == $project_id) : ?>
                                        <option value=" <?php echo $project['project_id'] ?>" selected>
                                        <?php else : ?>
                                        <option value="<?php echo $project['project_id'] ?>">
                                        <?php endif ?>
                                        <?php echo $project['project_name'] ?></option>
                                    <?php endforeach ?>
                            </select>
                        </form>
                        <input type="submit" value="Proceed" class="btn-primary" form="project_form">
                    </div>
                <?php endif ?>
            </div>


            <?php if (isset($_POST['project_id'])) : ?>

                <div class="wrapper">
                    <!-- Select Enroll -->
                    <div class="orto-wrapper left w3-container card">
                        <h4> Select Users to Enroll</h4>
                        <div class="w3-container">
                            <p>Users not enrolled in project</p>
                            <div class="scroll">
                                <?php foreach ($non_project_users as $npu) : ?>
                                    <p id="available_user_<?php echo $npu['user_id'] ?>" onclick="toggle_users_to_enroll(<?php echo $npu['user_id'] ?>)"><?php echo $npu['full_name'] ?></p>
                                <?php endforeach ?>
                                <?php if (count($non_project_users) == 0) : ?>
                                    <p><i>There are no available users</i></p>
                                <?php endif ?>
                            </div>
                            <p id="no_selected_users_to_enroll" class="error"></p>
                            <input type="button" value="Enroll" class="btn-primary" onclick="submit_enroll_form()">
                        </div>
                    </div>

                    <!-- Enroll form -->
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="enroll_form">
                        <input type="hidden" name="user_ids" value="" id="users_to_enroll">
                        <input type="hidden" name="enroll_users_submit" value="Submitted">
                        <input type="hidden" name="project_id" value="<?php echo $_POST['project_id'] ?>">
                    </form>

                    <!-- Select Disenroll -->
                    <div class="orto-wrapper right w3-container card">
                        <h4> Select Users to Disenroll</h4>
                        <div class="w3-container">
                            <p>Users currently enrolled in project</p>
                            <div class="scroll">
                                <?php foreach ($project_users as $pu) : ?>
                                    <p id="enrolled_user_<?php echo $pu['user_id'] ?>" onclick="toggle_users_to_disenroll(<?php echo $pu['user_id'] ?>)"><?php echo $pu['full_name'] ?></p>
                                <?php endforeach ?>
                            </div>
                            <p id="no_selected_users_to_disenroll" class="error"></p>
                            <input type="button" value="Disenroll" class="btn-primary" onclick="submit_disenroll_form()">
                        </div>
                    </div>

                    <!-- Disenroll form -->
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="disenroll_form">
                        <input type="hidden" name="user_ids" value="" id="users_to_disenroll">
                        <input type="hidden" name="disenroll_users_submit" value="Submitted">
                        <input type="hidden" name="project_id" value="<?php echo $_POST['project_id'] ?>">
                    </form>

                </div>
            <?php endif; ?>

            <!-- Modal response message for enrolled users-->
            <?php if (isset($_POST['enroll_users_submit'])) : ?>
                <?php $num_changed = 0 ?>
                <div id="enrolled_modal" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="document.getElementById('enrolled_modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <div class="w3-container">
                                <h5>
                                    You succesfully enrolled the following users to the selected project:
                                </h5>
                                <div class="w3-container w3-responsive">
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
                    document.getElementById('enrolled_modal').style.display = 'block';
                </script>
            <?php endif ?>

            <!-- Modal response message for dis-enrolled users-->
            <?php if (isset($_POST['disenroll_users_submit'])) : ?>
                <?php $num_changed = 0 ?>
                <div id="disenrolled_modal" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="document.getElementById('disenrolled_modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <div class="w3-container">
                                <h5>
                                    You succesfully dis-enrolled the following users from the selected project:
                                </h5>
                                <div class="w3-container w3-responsive">
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
                    document.getElementById('disenrolled_modal').style.display = 'block';
                </script>
            <?php endif ?>

        </div>

        <div style="height:500px;"></div>

    </div>

    <script>
        var selected_users_to_enroll = [];
        var selected_users_to_disenroll = [];

        function toggle_users_to_enroll(user_id) {
            if (!document.getElementById('available_user_' + user_id).classList.contains("active")) {
                document.getElementById('available_user_' + user_id).classList.add("active");
                selected_users_to_enroll.push(user_id);
            } else {
                document.getElementById('available_user_' + user_id).classList.remove("active");
                selected_users_to_enroll = selected_users_to_enroll.filter(function(value, index, arr) {
                    return value != user_id;
                })
            }
        }

        function toggle_users_to_disenroll(user_id) {
            if (!document.getElementById('enrolled_user_' + user_id).classList.contains("active")) {
                document.getElementById('enrolled_user_' + user_id).classList.add("active");
                selected_users_to_disenroll.push(user_id);
            } else {
                document.getElementById('enrolled_user_' + user_id).classList.remove("active");
                selected_users_to_enroll = selected_users_to_disenrolled.filter(function(value, index, arr) {
                    return value != user_id;
                })
            }
        }

        function submit_enroll_form() {
            var errors = false;
            if (selected_users_to_enroll.length == 0) {
                document.getElementById("no_selected_users_to_enroll").innerHTML = "No selected users";
                errors = true;
            } else {
                document.getElementById("no_selected_users_to_enroll").innerHTML = "";
            }
            if (!errors) {
                document.getElementById("users_to_enroll").value = JSON.stringify(selected_users_to_enroll);
                document.getElementById("enroll_form").submit();
            }
        }

        function submit_disenroll_form() {
            var errors = false;
            if (selected_users_to_disenroll.length == 0) {
                document.getElementById("no_selected_users_to_disenroll").innerHTML = "No selected users";
                errors = true;
            } else {
                document.getElementById("no_selected_users_to_disenroll").innerHTML = "";
            }
            if (!errors) {
                document.getElementById("users_to_disenroll").value = JSON.stringify(selected_users_to_disenroll);
                document.getElementById("disenroll_form").submit();
            }
        }
    </script>


    <?php include('shared/closing_tags.php'); ?>
    <script>
        set_active_link("manage_project_users");
    </script>