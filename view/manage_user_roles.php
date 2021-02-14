<?php
require('../control/shared/login_check.inc.php');
require_once('../control/controller.class.php');

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
                        <p>All users in your database</p>
                        <div class="scroll">
                            <?php foreach ($users as $user) : ?>
                                <?php $demo_users = array("Demo Admin", "Demo PM", "Demo Dev", "Demo Sub") ?>
                                <?php if (!in_array($user['full_name'], $demo_users)) : ?>
                                    <p id="<?php echo $user['user_id'] ?>" class="searchable" onclick="toggle_user(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] . ' | ' . $user['role_name'] ?></p>
                                <?php endif ?>
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
                                        <th>Created</th>
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
                                            <td><?php echo $user['created_at'] ?></td>
                                            <td><?php echo $user['updated_at'] ?></td>
                                            <?php if (isset($user['updated_by'])) : ?>
                                                <td><?php echo $user['updated_by'] ?></td>
                                            <?php else : ?>
                                                <td>None</td>
                                            <?php endif ?>
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

                        <form action="../control/manage_user_roles.inc.php" method="post" id="assign_role_form">
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
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
</div>

<?php if (isset($_SESSION['role_change_feedback'])) : ?>
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
                            <?php foreach ($_SESSION['selected_users'] as $selected_user) : ?>
                                <tr>
                                    <td><?php echo $selected_user['full_name'] ?></td>
                                    <td><?php echo $selected_user['role_name'] ?></td>
                                    <td><?php echo $_SESSION['new_role_name'] ?></td>
                                    <?php if ($selected_user['role_name'] !== $_SESSION['new_role_name']) : ?>
                                        <td style="color:green">Yes</td>
                                    <?php else : ?>
                                        <td style="color:red">No</td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php $num_selected = count($_SESSION['selected_users']); ?>
                    <p>Showing 1-<?php echo $num_selected; ?> of <?php echo $num_selected; ?> entries</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('id01').style.display = 'block';
    </script>
<?php endif ?>
<script>
    selected_users = [];

    function toggle_user(user_id) {
        if (!document.getElementById(user_id).classList.contains("active")) {
            document.getElementById(user_id).classList.add("active");
            selected_users.push(user_id);
            document.getElementById('row_' + user_id).style.display = "table-row";
            document.getElementById("no_selected_users_info").style.display = "none";
        } else {
            document.getElementById(user_id).classList.remove("active");
            selected_users = selected_users.filter(function(value, index, arr) {
                return value != user_id;
            })
            document.getElementById('row_' + user_id).style.display = "none";
            if (selected_users.length == 0) {
                document.getElementById("no_selected_users_info").style.display = "block";
            }

        }
    }
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const user_id = urlParams.get('user_id');
    if (user_id) {
        toggle_user(user_id);
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

    var search_items = document.getElementsByClassName("searchable");
    document.getElementById("search_field").addEventListener("input", function() {
        search_input = document.getElementById("search_field").value;
        for (let item of search_items) {
            var name = item.innerHTML;
            if (!name.toLowerCase().includes(search_input.toLowerCase())) {
                document.getElementById(item.id).style.display = "none";
            } else {
                document.getElementById(item.id).style.display = "block";
            }
        }
    });
</script>
<?php
require('page_frame/closing_tags.php');
require('../control/shared/clean_session.inc.php');
?>
<script>
    set_active_link("manage_user_roles");
</script>