<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
?>



<div class="main">
    <h2>My tickets</h2>

    <script>
        function set_active_link(new_active_link_id) {
            sidebar_items = ["dashboard", "manage_user_roles", "manage_project_users", "my_projects", "my_tickets"]
            sidebar_items.forEach(sidebar_item => {
                link_id = sidebar_item + "_link";
                document.getElementById(link_id).classList.remove("active");
            });
            document.getElementById(new_active_link_id).classList.add("active");
        }
        set_active_link("my_projects_link")
    </script>
</div>

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("my_tickets");
</script>