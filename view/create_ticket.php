<?php
require('../control/shared/login_check.inc.php');
require_once('../control/controller.class.php');

$contr = new Controller;

if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $selected_project = $contr->get_project_by_id($project_id);
    $enrolled_developers = $contr->get_project_users($_GET['project_id'], 3);
}
$projects = $contr->get_projects_by_user($_SESSION['user_id'], $_SESSION['role_name']);
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();

require('page_frame/ui_frame.php');
?>

<div class="main">
    <?php if (in_array($_SESSION['role_name'], ['Admin', 'Project Manager', 'Submitter'])) : ?>
        <?php if ($_GET['add_to_project'] == 0) : ?>
            <div class="create_ticket_no_parent_project">
                <div class="wrapper">
                    <!-- Select Project -->
                    <div class="orto-wrapper left w3-container card non-table-card">
                        <h4 class="project">Select a project </h4>
                        <div class="w3-container">
                            <input type="text" id="search_field_project" class="search_field" placeholder="Search project" value="<?php echo $_GET['search'] ?? '' ?>">
                            <p>
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
                            <table class="table bordered table-no-description">
                                <tr>
                                    <th>Project Name</th>
                                    <th>Created</th>
                                    <th>Last Update</th>
                                    <th>Details</th>
                                </tr>
                                <tr>
                                    <?php if (isset($project_id) && (!empty($project_id))) : ?>
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
            </div>
        <?php else : ?>
            <div class="create_ticket">
                <div class="top">
                    <!-- Parent Project -->
                    <div class="card ">
                        <div class="w3-container card-head">
                            <h4>Parent Project</h4>
                        </div>
                        <div class="w3-container">
                            <table class="table bordered table-no-description">
                                <tr>
                                    <th>Project Name</th>
                                    <th>Created</th>
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
            </div>
        <?php endif ?>

        <div class="create_ticket">
            <div class="card">
                <div class="w3-container card-head">
                    <h3>Create Ticket</h3>
                </div>
                <div class="card-content">
                    <form action="../control/create_ticket.inc.php" method="POST" class="w3-container" id="create_ticket_form">

                        <div class="text-input">
                            <div class="left">
                                <!-- Title -->
                                <p>
                                    <input type="text" name="title" maxlength="30" class="w3-input title" value="<?php echo $_SESSION['data']['title'] ?? ''; ?>">
                                    <label>Ticket Title</label><br>
                                    <span class="error">
                                        <?php echo $_SESSION['errors']['title'] ?? '' ?>
                                    </span>
                                </p>
                            </div>
                            <div class="right">
                                <!-- Description -->
                                <p>
                                    <input type="text" name="description" class="w3-input" value="<?php echo $_SESSION['data']['description'] ?? '' ?>">
                                    <label>Description</label><br>
                                    <span class="error">
                                        <?php echo $_SESSION['errors']['description'] ?? '' ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="other-input">
                            <div class="left">

                                <!-- Ticket Priority -->
                                <select class="w3-select" name="priority_id">
                                    <option value="" disabled selected>Choose Priority</option>
                                    <?php foreach ($priorities as $priority) : ?>
                                        <option value="<?php echo $priority['ticket_priority_id'] ?>" <?php if (isset($_SESSION['data']['priority_id'])) : ?> <?php if ($_SESSION['data']['priority_id'] == $priority['ticket_priority_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $priority['ticket_priority_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['priority'] ?? '' ?></p>
                                <label>Ticket Priority</label>

                                <!-- Ticket Type -->
                                <select class="w3-select" name="type_id">
                                    <option value="" disabled selected>Choose Ticket Type</option>
                                    <?php foreach ($types as $type) : ?>
                                        <option value="<?php echo $type['ticket_type_id'] ?>" <?php if (isset($_SESSION['data']['type_id'])) : ?> <?php if ($_SESSION['data']['type_id'] == $type['ticket_type_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $type['ticket_type_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['type'] ?? '' ?></p>
                                <label>Ticket Type</label>
                            </div>

                            <div class="right">

                                <!-- Developer Assigned -->
                                <select class="w3-select" name="developer_assigned">
                                    <option value="" disabled selected>Choose Developer</option>
                                    <?php foreach ($enrolled_developers as $enrolled_developer) : ?>
                                        <option value="<?php echo $enrolled_developer['user_id'] ?>" <?php if (isset($_SESSION['data']['developer_assigned']) && ($_SESSION['data']['developer_assigned'] == $enrolled_developer['user_id'])) : ?> selected<?php endif ?>>
                                            <?php echo $enrolled_developer['full_name'] . " | " . $enrolled_developer['role_name']; ?> </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['developer'] ?? '' ?></p>
                                <?php if (isset($project_id)) : ?>
                                    <label>Developer Assigned</label>
                                <?php else : ?>
                                    <label>Developer Assigned (select a project to see options)</label>
                                <?php endif ?>

                                <!-- Ticket Status -->
                                <select class="w3-select" name="status_id">
                                    <option value="" disabled selected>Choose Ticket Status</option>
                                    <?php foreach ($status_types as $status_type) : ?>
                                        <option value="<?php echo $status_type['ticket_status_id'] ?>" <?php if (isset($_SESSION['data']['status_id'])) : ?> <?php if ($_SESSION['data']['status_id'] == $status_type['ticket_status_id']) : ?> selected <?php endif ?> <?php endif ?>>
                                            <?php echo $status_type['ticket_status_name']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <p class="error"><?php echo $_SESSION['errors']['status'] ?? '' ?></p>
                                <label>Ticket Status</label>


                                <!-- Project ID -->
                                <input type="hidden" name="project_id" value="<?php echo $project_id ?? '' ?>" id="project_id_input">

                                <!-- Search Input -->
                                <input type="hidden" name="search_input" value="" id="search_input_to_post">

                                <!-- Add to project-->
                                <input type="hidden" name="add_to_project" value="<?php echo $_GET['add_to_project'] ?>">

                                <!-- Submitter -->
                                <input type="hidden" name="submitter" value="<?php echo $_SESSION['user_id'] ?>">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Submit button -->
            <div class="w3-container w3-center">
                <input type="submit" class="btn-primary below-card" value="Add Ticket to Project" form="create_ticket_form">
            </div>
        </div>
    <?php else : ?>
        <p>You dont' have permission to this page. Please contact your local administrator or project.</p>
    <?php endif ?>
</div>

<?php if ($_GET['add_to_project'] == 0) : ?>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        add_to_project = urlParams.get('add_to_project')

        function choose_project(project_id) {
            console.log(project_id);
            search_input = document.getElementById("search_field_project").value;
            document.getElementById('project_id_input').value = project_id;
            document.getElementById('search_input_to_post').value = search_input;
            //url = 'create_ticket.php?project_id=' + project_id + '&search=' + search_input + '&add_to_project=' + add_to_project;
            document.getElementById("create_ticket_form").submit();
        }

        function thin_out_projects(search_input_project) {
            for (let item of search_items_project) {
                if (!item.innerHTML.toLowerCase().includes(search_input_project.toLowerCase())) {
                    document.getElementById(item.id).style.display = "none";
                } else {
                    document.getElementById(item.id).style.display = "block";
                }
            }
        }

        var search_items_project = document.getElementsByClassName("searchable_project");
        document.getElementById("search_field_project").addEventListener("input", function() {
            search_input_project = document.getElementById("search_field_project").value;
            thin_out_projects(search_input_project);

        });

        search = urlParams.get('search');
        project_id = urlParams.get('project_id')
        if (search !== null) {
            thin_out_projects(search);
        }
        if (project_id !== null) {
            document.getElementById('project_' + project_id).classList.add("active");
        }
    </script>
<?php endif ?>


<?php
require('page_frame/closing_tags.php');
require('../control/shared/clean_session.inc.php');
?>

<script>
    set_active_link("manage_project_users");
</script>