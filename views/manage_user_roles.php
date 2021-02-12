<?php
require('../control/shared/login_check.inc.php');
require_once('../control/controller.class.php');

$contr = new Controller;
$users = $contr->get_users();
require('shared/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin'])) : ?>
        <div class="manage_user_roles">
            <div class="wrapper">
                <div class="orto-wrapper left card non-table-card">

                    <div class="w3-container">

                        <h4>Select one or more users </h4>
                        <div class="w3-container">
                            <input type="text" id="search_field" placeholder="Search name or role" style="width:300px;margin-bottom:5px;">
                            <div class="scroll w2-light-grey">
                                <?php foreach ($users as $user) : ?>
                                    <?php $demo_users = array("Demo Admin", "Demo PM", "Demo Dev", "Demo Sub") ?>
                                    <?php if (!in_array($user['full_name'], $demo_users)) : ?>
                                        <p id="<?php echo $user['user_id'] ?>" class="searchable" onclick="toggle_user(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] . ' | ' . $user['role_name'] ?></p>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                            <p id="no_selected_users" class="error"></p>
                        </div>

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

                        <h4>Submit changes</h4>
                        <div class="w3-container">
                            <input type="submit" value="Submit" class="btn-primary" onclick="submit_form()">
                        </div>

                    </div>

                </div>
                <div class="orto-wrapper right card">
                    <div class="w3-container card-head">
                        <h3>Your Personnel</h3>
                    </div>
                    <div class="w3-container">
                        <h5>
                            All users in your database
                        </h5>
                        <div class="w3-container">
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
                            <p class="entry-info">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p class="entry-info">Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="main">Only administrators and project managers have acces to this page. </div>
    <?php endif ?>
</div>

<!-- Model response message -->
<?php if (isset($_SESSION['role_change_succes'])) : ?>
    <?php $num_changed = 0 ?>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="w3-container">
                    <h5>You succesfully set the role of the following users</h5>
                    <div class="w3-container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>New Role</th>
                            </tr>
                            <?php foreach ($_SESSION['selected_users'] as $user_id) : ?>
                                <?php
                                $user = $contr->get_user_by_id($user_id);
                                $num_changed += 1
                                ?>
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
require('shared/closing_tags.php');
require('../control/shared/clean_session.inc.php');
?>
<script>
    set_active_link("manage_user_roles");
</script>