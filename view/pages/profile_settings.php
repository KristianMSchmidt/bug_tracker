<?php
require('../../control/shared/login_check.inc.php');
require('page_frame/ui_frame.php');
?>

<div class="main">
    <div class="profile_settings">
        <div class="card">
            <div class="w3-container card-head">
                <h4>Profile Settings</h4>
            </div>
            <div class="w3-container">
                <table class="table striped bordered">
                    <tr>
                        <td>Full name:</td>
                        <td><?php echo $_SESSION['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td>User ID:</td>
                        <td><?php echo $_SESSION['user_id'] ?></td>
                    </tr>
                    <tr>
                        <td>Current role:</td>
                        <td><?php echo $_SESSION['role_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $_SESSION['user_email'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php require('page_frame/closing_tags.php')
?>