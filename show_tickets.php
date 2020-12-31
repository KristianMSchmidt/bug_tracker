<?php
require 'templates/ui_frame.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('includes/db_connect.inc.php');

// write query for all projects
$sql =
    "SELECT tickets.*, projects.project_name, projects.id 
    FROM tickets JOIN projects 
    ON tickets.project_id = projects.id";


// make query and get result
$result = mysqli_query($conn, $sql);

// fetch the resulting rows as an associative array
$tickets = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<div class="main">

    <h3> All tickets </h3>
    <p> Search tickets___</p>
    <p> Show only tickets for project___</p>

    <table style="width:100%">
        <tr>
            <th>Ticket title</th>
            <th>Ticket description</th>
            <th>project name</th>
            <th>assigned developer</th>
            <th>ticket status</th>
            <th>Ticket type</th>
            <th>Prioryty</th>
            <th>submitter</th>
            <th>created_at</th>
        </tr>


        <?php foreach ($tickets as $ticket) : ?>

            <tr>
                <td><?php echo $ticket['title'] ?></td>
                <td><?php echo $ticket['ticket_description'] ?></td>
                <td><?php echo "<a href = 'show_project_details.php?id={$ticket['id']}'>{$ticket['project_name']}</a>"; ?></td>
                <td><?php echo get_username($ticket['developer_assigned']) ?></td>
                <td><?php echo $ticket_status_str[$ticket['status']] ?></td>
                <td><?php echo $ticket_type_str[$ticket['ticket_type']] ?></td>
                <td><?php echo $priority_str[$ticket['priority']] ?></td>
                <td><?php echo get_username($ticket['submitter']) ?></td>
                <td><?php echo $ticket['created_at'] ?></td>
                <td>
                    <form style="display:inline" action="show_ticket_details.php" method="GET">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                        <input type="hidden" name="project_name" value="<?php echo $ticket['project_name']; ?>">
                        <input type="hidden" name="project_id" value="<?php echo $ticket['id']; ?>">

                        <input type="submit" value="Details" name="show_ticket_details_submit">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    // free result from memory (good practice)
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);
    ?>

    <br>


</div><!-- main.div -->
</div> <!-- div.wrapper-->
</body>

</html>