<?php

include('../classes/dbh.class.php');
include('../classes/model.class.php');
include('../classes/controller.class.php');

$contr = new Controller;

//associative array
$tickets = $contr->get_tickets_by_user(1, 'Admin');

$tickets_str = json_encode($tickets);
echo "
<script>
        var tickets_js = {$tickets_str};
</script>";
?>


<script>
    console.log(tickets_js[0]['ticket_id']);

    // Get object keys
    console.log(Object.keys(tickets_js));
</script>



<script>
    //Alternative
    tickets_js = <?php echo $tickets_str  ?>
    // Get object keys
    console.log(tickets_js[0]['ticket_id']);

    console.log(JSON.stringify(tickets_js[0]));
</script>