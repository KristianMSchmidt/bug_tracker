<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include_once('../includes/auto_loader.inc.php');
$contr = new Controller();
$selected_project_name = $contr-> get_project_name_by_id($_POST['project_id'])['project_name'];


if ($_POST['requested_action'] == "create_ticket_attempt") {
    include('../classes/form_handlers/CreateTicketHandler.class.php');
    $create_ticket_handler = new CreateTicketHandler($_POST);
    $errors = $create_ticket_handler->process_input();
}
$projects = $contr->get_projects();
$priorities = $contr->get_priorities();
$types = $contr->get_ticket_types();
$status_types = $contr->get_ticket_status_types();
$developers = $contr->get_users_by_role_id(3);

include('shared/ui_frame.php');
?>

<style>
select{
    padding-top: 0.3em;
    padding-bottom:0.3em;}
</style>

<div class="new_main">
    <div class="edit_ticket">
        <div class="card">
            <div class="container card-head">
                <h2>Create Ticket</h2>
            </div>

            <div class="card-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="container">
                    <div class="text-input">
                        <div class="left">
                            <!-- Title -->
                            <p>
                                <input type="text" name="title" class="input" value="<?php echo $_POST['title'] ?? '' ?>">
                                <label>Ticket Title</label><br>
                                <span class="error">
                                    <?php echo $errors['title'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                        <div class="right">
                            <!-- Description -->
                            <p>
                                <input type="text" name="description" class="input" value="<?php echo $_POST['description'] ?? '' ?>">
                                <label>Description</label><br>
                                <span class="error">
                                    <?php echo $errors['description'] ?? '' ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="other-input">
                        <div class="left">
                             <!-- Project -->
                             <select class="select" name="project_id">
                                <?php foreach ($projects as $project) : ?> 
                                    <option value="<?php echo $project['project_id'] ?>" 
                                    <?php if ($_POST['project_id'] == $project['project_id']) : ?>
                                                selected 
                                            <?php endif ?>
                                        >
                                    <?php echo $project['project_name']; ?>                                    
                                    </option> 
                                <?php endforeach ?>
                            </select>
                            <label>Project</label>

                            <!-- Ticket Priority -->
                            <select class="select" name="priority_id">
                                <?php foreach ($priorities as $priority) : ?> 
                                    <option value="<?php echo $priority['ticket_priority_id'] ?>"
                                        <?php if(isset($_POST['priority_id'])) : ?>
                                            <?php if ($_POST['priority_id'] == $priority['ticket_priority_id']) : ?>
                                                selected 
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                    <?php echo $priority['ticket_priority_name']; ?>                                    
                                    </option> 
                                <?php endforeach ?>
                            </select>
                            <label>Ticket Priority</label>

                            <!-- Ticket Type -->
                            <select class="select" name="type_id">
                                <?php foreach ($types as $type) : ?> 
                                    <option value="<?php echo $type['ticket_type_id'] ?>"
                                        <?php if(isset($_POST['type_id'])) : ?>
                                            <?php if ($_POST['type_id'] == $type['ticket_type_id']) : ?>
                                                selected 
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                    <?php echo $type['ticket_type_name']; ?>                                    
                                    </option> 
                                <?php endforeach ?>
                            </select>
                            <label>Ticket Type</label>
                        </div>
                        <div class="right">
                             <!-- Developer Assigned -->
                             <select class="select" name="developer_assigned">
                                <?php foreach ($developers as $developer) : ?> 
                                    <option value="<?php echo $developer['user_id'] ?>"
                                        <?php if(isset($_POST['developer_assigned'])) : ?>
                                            <?php if ($_POST['developer_assigned'] == $developer['user_id']) : ?>
                                                selected 
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                    <?php echo $developer['full_name']; ?>                                    
                                    </option> 
                                <?php endforeach ?>
                            </select>
                            <label>Developer Assigned</label>

                            <!-- Ticket Status -->
                            <select class="select" name="status_id">
                                <?php foreach ($status_types as $status_type) : ?> 
                                    <option value="<?php echo $status_type['ticket_status_id'] ?>"
                                        <?php if(isset($_POST['status_id'])) : ?>
                                            <?php if ($_POST['status_id'] == $status_type['ticket_status_id']) : ?>
                                                selected 
                                            <?php endif ?>
                                        <?php endif ?>
                                    >
                                    <?php echo $status_type['ticket_status_name']; ?>                                    
                                    </option> 
                                <?php endforeach ?>
                            </select>
                            <label>Ticket Status</label>

                            <!-- Requested action -->
                            <input type="hidden" name="requested_action" value="create_ticket_attempt">

                            <!-- Submitter -->
                            <input type="hidden" name="submitter" value="<?php echo $_SESSION['user_id']?>">

                            <p class="error" style="text-align:center;">
                                <?php echo $errors['no_changes_error'] ?? '' ?>
                            </p>
                            <!-- Submit button -->
                            <div class="container" style="text-align:center">
                                <input type="submit" class="btn-primary" value="Create Ticket">
                            </div>
                        </div>
                    </div>
                  
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('shared/closing_tags.php') ?>


<script>
    set_active_link("my_tickets")
</script>