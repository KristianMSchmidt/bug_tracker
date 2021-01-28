<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
?>

<div class="main">
    <h2>Manage Project Users</h2>
    <?php
    print_r($_POST);
    ?>
</div>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("manage_project_users");
</script>