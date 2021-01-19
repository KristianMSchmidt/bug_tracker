<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
//$users = array(array('full_name' => "Kristian M", 'email' => 'krms@kvu.dk', 'role' => "admin"));
$contr = new controller;
$users = $contr->get_users();

?>

<div class="main">

    <div class="manage_user_roles">
        <h1>Manage User Roles</h1>
        <div class="row">
            <style>
                .scroll {
                    background-color: #eee;
                    width: 200px;
                    height: 150px;
                    border: 1px solid black;
                    overflow-y: scroll;
                    line-height: 1.5;
                }

                .scroll>p {
                    margin: 0;
                    padding: 0.5;
                }


                .active {
                    background-color: blue;
                }
            </style>


            <script>
                function g(user_id) {
                    console.log(user_id);
                    document.getElementById(user_id).classList.toggle("active");
                }
            </script>
            <div class="col" style="background-color:aqua">
                <p>Select 1 or more Users</p>
                <input type="text" value="" placeholder="Search name">
                <br>
                <div class="scroll">
                    <?php foreach ($users as $user) : ?>

                        <p id="<?php echo $user['user_id'] ?>" onclick="g(<?php echo $user['user_id'] ?>)"><?php echo $user['full_name'] ?></p>


                    <?php endforeach ?>

                </div>
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="new_role" value="">
                    <input type="submit" class="btn-primary" value="SUBMIT">
                </form>

                <p>Select the Role to assign</p>
                <div class="w3-dropdown-click">
                    <button onclick="myFunction()" class="w3-button w3-black">Click Me!</button>
                    <div id="Demo" class="w3-dropdown-content w3-bar-block w3-border">
                        <a href="#" class="w3-bar-item w3-button">Link 1</a>
                        <a href="#" class="w3-bar-item w3-button">Link 2</a>
                        <a href="#" class="w3-bar-item w3-button">Link 3</a>
                    </div>
                </div>

                <script>
                    function myFunction() {
                        var x = document.getElementById("Demo");
                        if (x.className.indexOf("w3-show") == -1) {
                            x.className += " w3-show";
                        } else {
                            x.className = x.className.replace(" w3-show", "");
                        }
                    }
                </script>

            </div>









            <div class="col">
                <div class="card">
                    <div class="container card-head">
                        <h3>Your Personnel</h3>
                    </div>
                    <div class="container">
                        <p>
                            All users in your database
                        </p>
                        <div class="container w3-responsive">
                            <table class="table striped bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                <?php foreach ($users as $user) : ?>

                                    <tr>
                                        <td><?php echo $user['full_name'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['role_name'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                        <p>Showing user 1-<?php echo count($users); ?> out of <?php echo count($users); ?>.</p>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include('shared/closing_tags.php') ?>
    <script>
        set_active_link("manage_user_roles");
    </script>