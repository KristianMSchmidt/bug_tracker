<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include('shared/ui_frame.php');
$contr = new Controller();

if ($_POST['requested_action'] == "edit_ticket_attempt") {

    $no_changes = true;
    if ($_POST['title'] != $_POST['old_title']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "TitleChange", $_POST['old_title'], $_POST['title']);
        $no_changes = false;
    }
    if ($_POST['project'] != $_POST['old_project']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "ProjectChange", $_POST['old_project'], $_POST['project']);
        $no_changes = false;
    }
    if ($_POST['priority'] != $_POST['old_priority']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "PriorityChange", $_POST['old_priority'], $_POST['priority']);
        $no_changes = false;
    }
    if ($_POST['type'] != $_POST['old_type']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "TypeChange", $_POST['old_type'], $_POST['type']);
        $no_changes = false;
    }
    if (trim($_POST['description']) != trim($_POST['old_description'])) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "DescriptionChange", $_POST['old_description'], $_POST['description']);
        $no_changes = false;
    }
    if ($_POST['status'] != $_POST['old_status']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "StatusChange", $_POST['old_status'], $_POST['status']);
        $no_changes = false;
    }
    if ($_POST['developer_assigned'] != $_POST['old_developer_assigned']) {
        $contr->add_to_ticket_history($_POST['ticket_id'], "AssignedTo", $_POST['old_developer_assigned'], $_POST['developer_assigned']);
        //Notify newly assigned developer
        $message = "assigned you to the ticket '{$_POST['title']}'";
        $contr->create_notification(2, $_POST['developer_assigned'], $message, $_SESSION['user_id']);
        //Notify previous assigned developer
        $message = "unassigned you from the ticket '{$_POST['title']}'";
        $contr->create_notification(3, $_POST['developer_assigned'], $message, $_SESSION['user_id']);
        $no_changes = false;
    }
    if ($no_changes) {
        $no_changes_error = "No changes were made";
    } else {
        $contr->set_ticket($_POST);
        header("location:ticket_details.php?ticket_id={$_POST['ticket_id']}");
        exit();
    }
}
$ticket = (array)  json_decode($_POST['ticket_json']);
$ticket_str = json_encode($ticket);

$projects = $contr->get_projects();
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$developers = $contr->get_users_by_role_id(3);
?>

<div class="new_main">
    <div class="edit_ticket">
        <div class="card">
            <div class="container card-head">
                <h2>Edit Ticket</h2>
            </div>

            <div class="card-content">
                <form action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="container" id="edit_ticket_form">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="input" id="title_input" value="<?php echo $ticket['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span id="title_error" class="error"></span>
                            </p>
                            <input type="hidden" name="old_title" value="<?php echo $ticket['title']; ?>">
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="input" id="description_input" value="<?php echo $ticket['description'] ?? '' ?>">
                                <label>Description</label><br>
                                <span id="description_error" class="error"></span>
                            </p>
                            <p class="error">
                                <?php echo $feedback['input_errors']['description'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                    <div class="other-input">
                        <div class="left">
                            <!-- Ticket Title -->



                            <!-- Project -->
                            <select class="select" name="project">
                                <option value="<?php echo $ticket['project_id'] ?>" selected><?php echo $ticket['project_name'] ?? '' ?></option>
                                <?php foreach ($projects as $project) : ?>
                                    <?php if ($project['project_id'] != $ticket['project_id']) : ?>
                                        <option value=<?php echo $project['project_id'] ?>><?php echo $project['project_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Project</label>
                            <input type="hidden" name="old_project" value="<?php echo $ticket['project_id']; ?>">


                            <!-- Ticket Priority -->
                            <select class="select" name="priority">
                                <option value=<?php echo $ticket['priority'] ?> selected><?php echo $ticket['ticket_priority_name']; ?></option>
                                <?php foreach ($priorities as $priority) : ?>
                                    <?php if ($priority['ticket_priority_id'] != $ticket['priority']) : ?>
                                        <option value=<?php echo $priority['ticket_priority_id'] ?>><?php echo $priority['ticket_priority_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Priority</label>
                            <input type="hidden" name="old_priority" value="<?php echo $ticket['priority']; ?>">

                            <!-- Ticket Type -->
                            <select class="select" name="type">
                                <option value=<?php echo $ticket['type'] ?> selected><?php echo $ticket['ticket_type_name'] ?></option>
                                <?php foreach ($types as $type) : ?>
                                    <?php if ($type['ticket_type_id'] != $ticket['type']) : ?>
                                        <option value=<?php echo $type['ticket_type_id'] ?>><?php echo $type['ticket_type_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Type</label>
                            <input type="hidden" name="old_type" value="<?php echo $ticket['type']; ?>">
                        </div>
                        <div class="right">

                            <input type="hidden" name="old_description" value="<?php echo $ticket['description']; ?>">


                            <!-- Developer Assigned -->
                            <select class="select" name="developer_assigned">
                                <option value=<?php echo $ticket['developer_assigned'] ?> selected><?php echo $ticket['developer_name'] ?></option>
                                <?php foreach ($developers as $developer) : ?>
                                    <?php if ($developer['user_id'] != $ticket['developer_assigned']) : ?>
                                        <option value=<?php echo $developer['user_id'] ?>><?php echo $developer['full_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Assigned Developer</label>
                            <input type="hidden" name="old_developer_assigned" value="<?php echo $ticket['developer_assigned']; ?>">


                            <!-- Ticket Status -->
                            <select class="select" name="status">
                                <option value=<?php echo $ticket['status'] ?> selected><?php echo $ticket['ticket_status_name'] ?></option>
                                <?php foreach ($status_types as $status_type) : ?>
                                    <?php if ($status_type['ticket_status_id'] != $ticket['status']) : ?>
                                        <option value=<?php echo $status_type['ticket_status_id'] ?>><?php echo $status_type['ticket_status_name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <label>Ticket Status</label>
                            <input type="hidden" name="old_status" value="<?php echo $ticket['status']; ?>">

                            <!-- Other post items we'll need -->
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                            <input type='hidden' name='ticket_json' id="ticket_json" value="">

                            <!-- hidden input -->
                            <input type="hidden" name="requested_action" value="edit_ticket_attempt">

                            <p class="error" style="text-align:center;"><?php echo $no_changes_error ?? '' ?></p>


                            <!-- Submit button -->
                            <div class="container" style="text-align:center">
                                <button class="btn-primary" onclick="submit_form()">Make Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function submit_form() {
        errors = false;
        const title = document.getElementById("title_input").value;
        const description = document.getElementById("description_input").value;
        if (title == "") {
            document.getElementById("title_error").innerHTML = "Ticket needs a title";
            errors = true;
        } else if (title.length < 5 || title.length > 45) {
            document.getElementById("title_error").innerHTML = "Title must be 5-45 chars";
            errors = true;
        } else {
            document.getElementById("title_error").innerHTML = "";
        };

        if (description == "") {
            document.getElementById("description_error").innerHTML = "Ticket needs a description";
            errors = true;
        } else if (description.length < 5 || title.length > 100) {
            document.getElementById("description_error").innerHTML = "Desctiption must be 5-100 chars";
            errors = true;
        } else {
            document.getElementById("description_error").innerHTML = "";
        };

        if (!errors) {
            document.getElementById("edit_ticket_form").submit();
        }
    }
</script>

<?php echo "
<script>
    var ticket_js = {$ticket_str}
    document.getElementById('ticket_json').value = JSON.stringify(ticket_js); 
</script>";
?>





<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_tickets")
</script>