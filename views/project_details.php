<?php
include('../includes/login_check.inc.php');
include('../includes/post_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$project = $contr->get_project_by_id($_POST['project_id']);
$users = $contr->get_project_users($_POST['project_id']);
$tickets = $contr->get_tickets_by_project($_POST['project_id']);
?>

<div class="new_main">
    <div class="project_details">
        <div class="top">
            <div class="container">
                <h1>Details for Project #<?php echo $project['project_id'] ?></h1>
                <div class="container" style="margin-bottom:1em">
                    <h5><span style="color:grey;">Project Name:</span> <?php echo $project['project_name'] ?></h5>
                    <h5><span style="color:grey;">Description:</span> <?php echo $project['project_description'] ?></h5>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="bottom-left">
                <form action="create_ticket.php" method="post">
                    <input type="hidden" name="project_id" value="<?php echo $_POST['project_id']; ?>">
                    <input type="hidden" name="requested_action" value="go_to_create_ticket_page">
                    <input type="submit" value="CREATE NEW TICKET" class="btn-primary large">
                </form>
                <div class="card">
                    <div class="container card-head">
                        <h4>Tickets for this Project</h4>
                    </div>
                    <div class="container">

                        <h5>Condenced ticket Details</h5>
                    </div>
                    <div class="container w3-responsive">
                        <table class="table striped bordered">
                            <tr>
                                <th>Title</th>
                                <th>Submitter</th>
                                <th>Developer</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>

                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['title'] ?></td>
                                    <td><?php echo $ticket['submitter_name'] ?></td>
                                    <td><?php echo $ticket['developer_name'] ?></td>
                                    <td><?php echo $ticket['ticket_status_name'] ?></td>
                                    <td><?php echo $ticket['created_at'] ?></td>
                                    <td><a href="#" onclick="ticket_details_submitter(<?php echo $ticket['ticket_id'] ?>)">Ticket Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php if (count($tickets) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no tickets for this project in the database</p>
                            </div>
                            <p style="font-size:12px">Showing 0-0 of 0 entries</p>
                        <?php else : ?>
                            <p style="font-size:12px">Showing 1-<?php echo count($tickets); ?> of <?php echo count($tickets); ?> entries</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="bottom-right">
                <form action="manage_project_users.php" method="post">
                    <input type="hidden" name="project_id" value="<?php echo $_POST['project_id']; ?>">
                    <input type="submit" value="MANAGE PROJECT USERS" class="btn-primary large" style="width: 16em;">
                </form>
                <div class="card">
                    <div class="container card-head">
                        <h4>Assigned Personel</h4>
                    </div>
                    <div class="container">
                        <h5>Current Users on this Project</h5>
                    </div>
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
                        <?php if (count($users) == 0) : ?>
                            <div class="empty-table-row">
                                <p>There are no users assigned to this project</p>
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
    <?php if ($_POST['requested_action'] == 'show_created_ticket_succes_message') : ?>
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container">
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <div class="container">
                        <p style="margin-top:3em; margin-bottom:3em;">
                            You succesfully created at ticket for this project
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('id01').style.display = 'block';
        </script>
    <?php endif ?>
</div>


<form action="ticket_details.php" method="post" id="form">
    <input type="hidden" name="ticket_id" id="ticket_id" value="">
    <input type="hidden" name="requested_action" value="">
</form>


<script>
    function ticket_details_submitter(i) {
        document.getElementById("ticket_id").value = i;
        document.getElementById("form").submit()
    }
</script>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>