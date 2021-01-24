<?php
include('../includes/login_check.inc.php');
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
} else {
    //header('location: dashboard.php');
    //exit();
    print_r($_GET);
}
include('shared/ui_frame.php');
$contr = new controller;
$history = $contr->get_ticket_history($ticket_id);

?>

<div class="new_main">
    <h1>Details for Ticket #<?php echo $_GET['ticket_id']; ?></h1>
    <h3>Ticket History</h3>
    <?php print_r($history); ?>


</div>
<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("manage_user_roles");
</script>