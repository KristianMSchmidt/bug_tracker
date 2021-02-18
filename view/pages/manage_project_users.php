<?php
require('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');

$contr = new Controller;
$projects = $contr->get_projects_by_user($_SESSION['user_id'], $_SESSION['role_name']);

if ($_GET['project_id'] !== "none") {
    $project_id = $_GET['project_id'];
    $project_users = $contr->get_project_users($project_id, "all_roles");
    $non_project_users = $contr->get_users_not_enrolled_in_project($project_id);
    $selected_project = $contr->get_project_by_id($project_id);
}
require('page_frame/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager'])) : ?>
        <div class="manage_project_users">
            <div class="wrapper">
                <!-- Select Project -->
                <div class="orto-wrapper left w3-container card non-table-card">
                    <h4 class="project">Select a project</h4>
                    <div class="w3-container">
                        <input type="text" id="search_field_project" class="search_field" placeholder="Search project" value="<?php echo $_GET['search'] ?? '' ?>">
                        <p class="small-label">
                            <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                                All projects in the database
                            <?php else : ?>
                                All your projects in the database
                            <?php endif ?>
                        </p>
                        <div class="scroll">
                            <?php foreach ($projects as $project) : ?>
                                <p id="project_<?php echo $project['project_id'] ?>" class="searchable_project" onclick="choose_project(<?php echo $project['project_id'] ?>)"><?php echo $project['project_name'] ?></p>
                            <?php endforeach ?>
                            <?php if (count($projects) == 0) : ?>
                                <p>There are no projects in the database</p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <!-- Selected Project -->
                <div class=" orto-wrapper right card ">
                    <div class="w3-container card-head">
                        <h4>Selected Project</h4>
                    </div>
                    <div class="w3-container">
                        <table class="w3-table w3-bordered table-no-description">
                            <tr>
                                <th>Project Name</th>
                                <th class="hide_if_needed"> Created</th>
                                <th>Last Update</th>
                                <th>Details</th>
                            </tr>
                            <tr>
                                <?php if (isset($project_id)) : ?>
                                    <td><?php echo $selected_project['project_name']; ?></td>
                                    <td><?php echo $selected_project['created_at']; ?></td>
                                    <td><?php echo $selected_project['updated_at']; ?></td>
                                    <td> <a href="project_details.php?project_id=<?php echo $project_id ?>" class="right"> Project Details</a></td>
                                <?php endif ?>
                            </tr>
                        </table>
                        <?php if (!isset($project_id)) : ?>
                            <div class="empty-table-row">
                                <p>No selected project</p>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <!-- Select Enroll -->
                <div class="orto-wrapper bottom left w3-container card non-table-card">
                    <h4> Select users enroll</h4>
                    <div class="w3-container">
                        <input type="text" id="search_field_enroll" class="search_field" placeholder="Search name">
                        <p class="small-label">Available users</p>
                        <div class="scroll">
                            <?php if (isset($project_id)) : ?>
                                <?php foreach ($non_project_users as $npu) : ?>
                                    <p id="available_user_<?php echo $npu['user_id'] ?>" class="searchable_enroll" onclick="toggle_users_to_enroll(<?php echo $npu['user_id'] ?>)"><?php echo $npu['full_name'] . ' | ' . $npu['role_name'] ?></p>
                                <?php endforeach ?>

                                <?php if (count($non_project_users) == 0) : ?>
                                    <p>All users are are currently enrolled in this project</p>
                                <?php endif ?>
                            <?php else : ?>
                                <p style="color:grey;"><i>Select project to see options</i></p>
                            <?php endif ?>
                        </div>
                        <p id="enroll_error" class="error"></p>
                        <input type="button" value="ENROLL" class="btn-primary" onclick="submit_enroll_form()">
                    </div>
                    <?php if (isset($project_id)) : ?>
                        <!-- Enroll form -->
                        <form action="../../control/manage_project_users.inc.php" method="post" id="enroll_form">
                            <input type="hidden" name="user_ids" value="" id="users_to_enroll">
                            <input type="hidden" name="enroll_users_submit" value="Submitted">
                            <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                        </form>
                    <?php endif ?>
                </div>
                <!-- Select Disenroll -->
                <div class="orto-wrapper bottom right w3-container card non-table-card">
                    <h4 class="small-label"> Select users to disenroll</h4>
                    <div class="w3-container">
                        <input type="text" id="search_field_disenroll" class="search_field" placeholder="Search name">
                        <p class="small-label">Users already enrolled in project</p>
                        <div class="scroll">
                            <?php if (isset($project_id)) : ?>
                                <?php foreach ($project_users as $pu) : ?>
                                    <p id="enrolled_user_<?php echo $pu['user_id'] ?>" class="searchable_disenroll" onclick="toggle_users_to_disenroll(<?php echo $pu['user_id'] ?>)"><?php echo $pu['full_name'] . ' | ' . $pu['role_name'] ?></p>
                                <?php endforeach ?>
                                <?php if (count($project_users) == 0) : ?>
                                    <p>There are currently no users enrolled in this project</p>
                                <?php endif ?>
                            <?php else : ?>
                                <p style="color:grey;"><i>Select project to see options</i></p>
                            <?php endif ?>

                        </div>
                        <p id="disenroll_error" class="error"></p>
                        <input type="button" value="DIS-ENROLL" class="btn-primary" onclick="submit_disenroll_form()">
                    </div>
                    <?php if (isset($project_id)) : ?>
                        <!-- Disenroll form -->
                        <form action="../../control/manage_project_users.inc.php" method="post" id="disenroll_form">
                            <input type="hidden" name="user_ids" value="" id="users_to_disenroll">
                            <input type="hidden" name="disenroll_users_submit" value="Submitted">
                            <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>

    <?php else : ?>
        <p>You dont' have permission manage user roles. Please contact your local administrator or project manager.</p>
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
                        <table class="w3-table w3-striped w3-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                            <?php foreach ($_SESSION['selected_users'] as $user_id) : ?>
                                <?php
                                $user = $contr->get_users($user_id)[0];
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
                        <table class="w3-table w3-striped w3-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>New Role</th>
                            </tr>
                            <?php foreach ($_SESSION['selected_users'] as $user_id) : ?>
                                <?php $user = $contr->get_users($user_id)[0];
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

<script src="../js/manage_project_users.js"></script>

<?php
require('page_frame/closing_tags.php');
?>

<script>
    set_active_link("manage_project_users");
</script>