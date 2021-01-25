<?php

include('../includes/login_check.inc.php');
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
} elseif (isset($_POST['ticket_id'])) {
    $ticket_id = $_POST['ticket_id'];
} else {
    header('location: dashboard.php');
    exit();
}

include('shared/ui_frame.php');

if (isset($_POST['show_next'])) {
    $LIMIT = $_POST['LIMIT'];
    $OFFSET = $_POST['OFFSET'] + $LIMIT;
} else {
    //initial values
    $LIMIT = 2;
    $OFFSET = 0;
}
$contr = new controller;

$history = $contr->get_ticket_history($ticket_id, $OFFSET, $LIMIT);

?>

<div class="new_main">
    <h1>Details for Ticket #<?php echo $ticket_id ?></h1>
    <h3>Ticket History</h3>
    <?php print_r($history); ?>


    <form action="ticket_details.php" method="post">
        OFFSET: <input type="number" name="OFFSET" id="offset" value=<?php echo $OFFSET ?>>
        LIMIT: <input type="number" name="LIMIT" id="limit" value=<?php echo $LIMIT ?>>
        <input type="hidden" name="ticket_id" value=<?php echo $ticket_id ?>>
        <input type="submit" name="show_next" value="Show next">

    </form>


</div>

<script>
    function f() {
        offset = document.getElementById("offset").value;
        limit = document.getElementById("limit").value;

    }
</script>
<?php include('shared/closing_tags.php') ?>
<script>
    set_active_link("manage_user_roles");
</script>