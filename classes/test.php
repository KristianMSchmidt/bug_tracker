<?php
include 'dbh.class.php';

include 'notifications.class.php';
include('../includes/human_timing.inc.php');

session_start();
if (isset($_SESSION['user_id'])) {
    include_once('../includes/auto_loader.inc.php');
    $notif_handler = new Notifications;
    $data = $notif_handler->get_notifications_by_user_id($_SESSION['user_id']);
}
?>
<?php foreach ($data['notifications'] as $notification) : ?>
    <?php
    if ($notification['notification_type'] == 1) {
        echo '<a href="profile_settings.php">';
    } elseif ($notification['notification_type'] == 2) {
        echo '<a href="my_tickets.php">';
    } elseif ($notification['notification_type'] == 3) {
        echo '<a href="my_projects.php">';
    }
    ?>
    <?php echo '<b>' . $notification["created_by"] . '</b>'; ?>
    <?php echo $notification["notification"]; ?>
    <?php $elapsed_time = human_timing(strtotime($notification["created_at"])); ?>
    <?php echo '<br>' . $elapsed_time . ' ago'; ?>
    </a>
<?php endforeach; ?>