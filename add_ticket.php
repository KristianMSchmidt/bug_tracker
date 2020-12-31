<?php
require "templates/ui_frame.php";

if (!($role_str[$_SESSION['role']] == "Admin" || $role_str[$_SESSION['role']] == "Project Manager")) {
    echo "<p class='logi    nerror'>Tickets can only be added by admin or project manager<p>";
    exit();
}

?>

<div class="main">
    <h2>Add ticket</h2>
    <h3>Add ticket to project #<?php echo $_GET['project_id']; ?>: <?php echo $_GET['project_name'] ?> </h3>

    <?php

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'notitle') {
            echo '<p class="loginerror">Your project needs a title</p>';
        }
    }
    ?>

    <form action="includes/add_ticket.inc.php" method="POST">

        <input type="text" name="title" placeholder="Ticket title"><br>

        <input type="text" name="description" placeholder="Description"><br>

        <label for "ticket_priority">Priority</label>
        <select id="ticket_priority" name="ticket_priority">
            <option value=5 selected="selected"><?php echo $priority_str[5] ?></option>
            <option value=6><?php echo $priority_str[6] ?></option>
            <option value=7><?php echo $priority_str[7] ?></option>
            <option value=8><?php echo $priority_str[8] ?></option>
        </select><br>

        <label for "ticket_type>Type</label>
            <select id=" ticket_type" name="ticket_type">
            <option value=1 selected="selected"><?php echo $ticket_type_str[1] ?></option>
            <option value=2><?php echo $ticket_type_str[2] ?></option>
            <option value=3><?php echo $ticket_type_str[3] ?></option>
            </select><br>

            <label for "ticket_status">Status</label>
            <select id="ticket_status" name="ticket_status">
                <option value=1 selected="selected"><?php echo $ticket_status_str[1] ?></option>
                <option value=2><?php echo $ticket_status_str[2] ?></option>
                <option value=3><?php echo $ticket_status_str[3] ?></option>
                <option value=4><?php echo $ticket_status_str[4] ?></option>
            </select><br>

            <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">

            <input type="hidden" name="project_name" value="<?php echo $_GET['project_name']; ?>">

            <br>
            <input type="submit" name="add_ticket_submit" value="Add ticket"><br>

    </form>
</div> <!-- div.main -->
</div> <!-- div.wrapper-->
</body>

</html>