<?php
include('../includes/login_check.inc.php');
include_once('../includes/auto_loader.inc.php');

$contr = new Controller;
$projects = $contr->get_projects();

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $project_users = $contr->get_project_users($project_id);
    $non_project_users = $contr->get_users_not_enrolled_in_project($project_id);
    $project_name = $contr->get_project_name_by_id($project_id)['project_name'];
    echo "<script>var project_id = true</script>";
} else if (isset($_GET['select_project_submit'])) {
    $select_project_error = 'Select a project';
}

if (isset($_POST['enroll_users_submit'])) {
    $selected_users = json_decode($_POST['user_ids']);
    $project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
    $notification_message = "enrolled you in the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->assign_to_project($user_id, $_POST['project_id']);
        $contr->create_notification(4, $user_id, $notification_message, $_SESSION['user_id']);
    }
    $_SESSION['enroll_users_succes'] = true;
    $_SESSION['selected_users'] = $selected_users;
    header("location: manage_project_users.php?project_id={$_POST['project_id']}");
    exit();
}

if (isset($_POST['disenroll_users_submit'])) {
    $selected_users = json_decode($_POST['user_ids']);
    $project_name = $contr->get_project_name_by_id($_POST['project_id'])['project_name'];
    $notification_message = "disenrolled your from the project '{$project_name}'";
    foreach ($selected_users as $user_id) {
        $contr->unassign_from_project($user_id, $_POST['project_id']);
        $contr->create_notification(5, $user_id, $notification_message, $_SESSION['user_id']);
    }
    $_SESSION['disenroll_users_succes'] = true;
    $_SESSION['selected_users'] = $selected_users;
    header("location: manage_project_users.php?project_id={$_POST['project_id']}");
    exit();
}
include('shared/ui_frame.php');
?>


<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="manage_project_users">
            <div class="wrapper">
                <div class="orto-wrapper left top card non-table-card">

                    <div class="w3-container">
                        <h3 class="project">Select Project</h3>

                        <div class="w3-container">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" id="project_form">
                                <select class="w3-select" name="project_id">
                                    <?php if (!isset($project_id)) : ?>
                                        <option value="" disabled selected>Choose Project</option>
                                        <?php foreach ($projects as $project) : ?>
                                            <option value=" <?php echo $project['project_id'] ?>"><?php echo $project['project_name'] ?></option>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <?php foreach ($projects as $project) : ?>
                                            <?php if ($project['project_id'] == $_POST['project_id']) : ?>
                                                <option value=" <?php echo $project['project_id'] ?>" selected> <?php echo $project['project_name'] ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $project['project_id'] ?>"> <?php echo $project['project_name'] ?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <input type="hidden" name="select_project_submit" value="Select" class="btn-primary" form="project_form">
                            </form>
                            <p class="error"><?php echo $select_project_error ?? '' ?></p>
                            <input type="submit" value="Select" class="btn-primary" form="project_form">
                        </div>
                    </div>
                </div>
                <div class="orto-wrapper right card ">
                    <div class="w3-container card-head">
                        <h4>Selected Project</h4>
                    </div>
                    <div class="w3-container">
                        <table class=" table bordered">
                            <tr>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Details</th>
                            </tr>
                            <tr>
                                <?php if (isset($project_id)) : ?>
                                    <td><?php echo $project_id ?></td>
                                    <td><?php echo $project_name ?></td>
                                    <td> <a href="project_details.php?project_id=<?php echo $project_id ?>" class="right">Project Details</a></td>
                                <?php else : ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <?php endif ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="wrapper">
                <!-- Select Enroll -->
                <div class="orto-wrapper left w3-container card non-table-card">
                    <h3> Select Users to Enroll</h3>
                    <div class="w3-container">
                        <p>Users not enrolled in project</p>
                        <div class="scroll">
                            <?php if (isset($project_id)) : ?>
                                <?php foreach ($non_project_users as $npu) : ?>
                                    <p id="available_user_<?php echo $npu['user_id'] ?>" onclick="toggle_users_to_enroll(<?php echo $npu['user_id'] ?>)"><?php echo $npu['full_name'] . ' | ' . $npu['role_name'] ?></p>
                                <?php endforeach ?>

                                <?php if (count($non_project_users) == 0) : ?>
                                    <p>All users are are currently enrolled in this project</p>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <p id="enroll_error" class="error"></p>
                        <input type="button" value="Enroll" class="btn-primary" onclick="submit_enroll_form()">
                    </div>
                </div>
                <?php if (isset($project_id)) : ?>
                    <!-- Enroll form -->
                    <form action="" method="post" id="enroll_form">
                        <input type="hidden" name="user_ids" value="" id="users_to_enroll">
                        <input type="hidden" name="enroll_users_submit" value="Submitted">
                        <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                    </form>
                <?php endif ?>

                <!-- Select Disenroll -->
                <div class="orto-wrapper right w3-container card non-table-card">
                    <h3> Select Users to Disenroll</h3>
                    <div class="w3-container">
                        <p>Users enrolled in project</p>
                        <div class="scroll">
                            <?php if (isset($project_id)) : ?>
                                <?php foreach ($project_users as $pu) : ?>
                                    <p id="enrolled_user_<?php echo $pu['user_id'] ?>" onclick="toggle_users_to_disenroll(<?php echo $pu['user_id'] ?>)"><?php echo $pu['full_name'] . ' | ' . $pu['role_name'] ?></p>
                                <?php endforeach ?>
                                <?php if (count($project_users) == 0) : ?>
                                    <p>There are currently no users enrolled in this project</p>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <p id="disenroll_error" class="error"></p>
                        <input type="button" value="Disenroll" class="btn-primary" onclick="submit_disenroll_form()">
                    </div>
                </div>

                <?php if (isset($project_id)) : ?>

                    <!-- Disenroll form -->
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="disenroll_form">
                        <input type="hidden" name="user_ids" value="" id="users_to_disenroll">
                        <input type="hidden" name="disenroll_users_submit" value="Submitted">
                        <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                    </form>
                <?php endif ?>

            </div>

            <!-- Modal response message for enrolled users-->
            <?php if (isset($_SESSION['enroll_users_succes'])) : ?>
                <?php $num_changed = 0 ?>
                <div id="enrolled_modal" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="document.getElementById('enrolled_modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <div class="w3-container">
                                <h5>
                                    You succesfully enrolled the following users to the selected project:
                                </h5>
                                <div class="w3-container">
                                    <table class="table striped bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>New Role</th>
                                        </tr>
                                        <?php foreach ($_SESSION['selected_users'] as $user_id) : ?>
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
            <?php if (isset($_SESSION['disenroll_users_succes'])) : ?>
                <?php $num_changed = 0 ?>
                <div id="disenrolled_modal" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="document.getElementById('disenrolled_modal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <div class="w3-container">
                                <h5>
                                    You succesfully dis-enrolled the following users from the selected project:
                                </h5>
                                <div class="w3-container">
                                    <table class="table striped bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>New Role</th>
                                        </tr>
                                        <?php foreach ($_SESSION['selected_users'] as $user_id) : ?>
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

    <?php else : ?>
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
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
            selected_users_to_disenroll = selected_users_to_disenroll.filter(function(value, index, arr) {
                return value != user_id;
            })
        }
    }

    function submit_enroll_form() {
        var errors = false;
        if (typeof(project_id) == 'undefined') {
            document.getElementById("enroll_error").innerHTML = "No selected project";
        } else if (selected_users_to_enroll.length == 0) {
            document.getElementById("enroll_error").innerHTML = "No selected users";
            errors = true;
        } else {
            document.getElementById("enroll_error").innerHTML = "";
        }
        if (!errors) {
            document.getElementById("users_to_enroll").value = JSON.stringify(selected_users_to_enroll);
            document.getElementById("enroll_form").submit();
        }
    }

    function submit_disenroll_form() {
        var errors = false;
        if (typeof(project_id) == 'undefined') {
            document.getElementById("disenroll_error").innerHTML = "No selected project";
        } else if (selected_users_to_disenroll.length == 0) {
            document.getElementById("disenroll_error").innerHTML = "No selected users";
            errors = true;
        } else {
            document.getElementById("disenroll_error").innerHTML = "";
        }
        if (!errors) {
            document.getElementById("users_to_disenroll").value = JSON.stringify(selected_users_to_disenroll);
            document.getElementById("disenroll_form").submit();
        }
    }
</script>



<?php
//TODO lav lille script der sletter midlertidlige session variable
unset($_SESSION['disenroll_users_succes']);
unset($_SESSION['enroll_users_succes']);
unset($_SESSION['selected_users']);
include('shared/closing_tags.php');
?>
<script>
    set_active_link("manage_project_users");
</script>