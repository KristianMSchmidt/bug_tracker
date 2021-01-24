<?php
include('../includes/login_check.inc.php');
//include('../includes/post_check.inc.php');
include('shared/ui_frame.php');

$contr = new controller;
$project = $contr->get_project_by_id($_POST['project_id']);
$users = $contr->get_project_users($_POST['project_id']);
$tickets = $contr->get_tickets_by_project($_POST['project_id']);

?>


<div class="new_main">
    <div class="project_details">
        <div class="top">
            <div class="container card-head">
                <h1>Details for Project #<?php echo $project['project_id'] ?></h1>
                <div class="container" style="margin-bottom:1em">
                    <p><span style="color:grey;">Project Name:</span> <?php echo $project['project_name'] ?></p>
                    <p><span style="color:grey;">Description:</span> <?php echo $project['project_description'] ?></p>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="bottom-left">
                <div class="card">
                    <div class="container card-head">
                        <h4>Assigned Personel</h4>
                    </div>
                    <div class="container">
                        <p>Current Users on this Project</p>
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
                    </div>

                </div>
            </div>
            <div class="bottom-right">
                <div class="card">
                    <div class="container card-head">
                        <h4>Tickets for this Project</h4>
                    </div>
                    <div class="container">

                        <p>Condenced ticket Details</p>
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
                                    <td><a href="ticket_details.php?ticket_id=<?php echo $ticket['ticket_id']; ?>">More Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_projects")
</script>