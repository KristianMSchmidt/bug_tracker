<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
?>

<div class="main">
    <div class="profile_settings">
        <div class="card">
            <div class="w3-container card-head">
                <h4>Profile Settings</h4>
            </div>
            <div class="w3-container">
                <table>
                    <tr>
                        <td class="pad-right" cladd>Full name:</td>
                        <td><?php echo $_SESSION['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="pad-right">User ID:</td>
                        <td><?php echo $_SESSION['user_id'] ?></td>
                    </tr>
                    <tr>
                        <td class="pad-right">Current role:</td>
                        <td><?php echo $_SESSION['role_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="pad-right">Email:</td>
                        <td><?php echo $_SESSION['user_email'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('shared/closing_tags.php') ?>