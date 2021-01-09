    <?php
    require('includes/check_login.inc.php');
    include('includes/autoLoader.inc.php');
    require('templates/ui_frame.php');
    $modelObj = new Model;
    $projects = $modelObj->getProjectsByUserId($_SESSION['user_id']);

    //require('includes/fetch_my_projects.inc.php');
    ?>

    <div class="main">
        <div class="container pt-3">
            <form action="create_project.php">
                <input type="submit" value="CREATE NEW PROJECT" class="btn btn-primary">
            </form>

            <div class="row justify-content-center pt-3">
                <!-- Col to control width of table. Col-12 is full width -->
                <div class="col-sm-11">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Table-width controlled by col-11</h5>
                            <div class="card-text">Scalable solution</div>

                            <table class="table table-sm bg-light">
                                <caption>Showing first 10 users</caption>
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($projects as $project) : ?>
                                        <?php $form_id = "project_details_form_" . $project['project_id'] ?>

                                        <form action="show_project_details.php" method="post" id="<?php echo $form_id ?>">
                                            <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?> ">
                                            <input type="hidden" name="project_name" value="<?php echo $project['project_name'] ?> ">
                                            <input type="hidden" name="project_description" value="<?php echo $project['project_description'] ?> ">
                                        </form>

                                        <tr>
                                            <td><?php echo $project['project_name'] ?></td>
                                            <td><?php echo $project['project_description'] ?></td>
                                            <td>
                                                <a href="#">Manage Users</a> <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">More Details</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            Her er et kort
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid pt-3">
            <form action="create_project.php">
                <input type="submit" value="CREATE NEW PROJECT" class="btn btn-primary btn-square">
            </form>
            <div class="container-fluid pt-3">
                <div class="card" style="width:fit-content;">
                    <div class="card-body">
                        <h5 class="card-title">Your projects</h5>
                        <p class="card-text">As admin you see all projects in the database</p>
                        <table class="table table-sm bg-light">
                            <caption>Showing first 10 users</caption>
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project) : ?>
                                    <?php $form_id = "project_details_form_" . $project['project_id'] ?>

                                    <form action="show_project_details.php" method="post" id="<?php echo $form_id ?>">
                                        <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?> ">
                                        <input type="hidden" name="project_name" value="<?php echo $project['project_name'] ?> ">
                                        <input type="hidden" name="project_description" value="<?php echo $project['project_description'] ?> ">
                                    </form>

                                    <tr>
                                        <td><?php echo $project['project_name'] ?></td>
                                        <td><?php echo $project['project_description'] ?></td>
                                        <td>
                                            <a href="#">Manage Users</a><br>
                                            <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">More Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid pt-3">
            <form action="create_project.php">
                <input type="submit" value="CREATE NEW PROJECT" class="btn btn-primary btn-square">
            </form>
            <div class="container-fluid pt-3">
                <h5>Your projects</h5>
                <p>As admin you see all projects in the database</p>
                <table class="table table-sm bg-light">
                    <caption>Showing first 10 users</caption>
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project) : ?>
                            <?php $form_id = "project_details_form_" . $project['project_id'] ?>

                            <form action="show_project_details.php" method="post" id="<?php echo $form_id ?>">
                                <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?> ">
                                <input type="hidden" name="project_name" value="<?php echo $project['project_name'] ?> ">
                                <input type="hidden" name="project_description" value="<?php echo $project['project_description'] ?> ">
                            </form>

                            <tr>
                                <td><?php echo $project['project_name'] ?></td>
                                <td><?php echo $project['project_description'] ?></td>
                                <td>
                                    <a href="#">Manage Users</a><br>
                                    <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">More Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-fluid pt-3">
            <form action="create_project.php">
                <input type="submit" value="CREATE NEW PROJECT" class="btn btn-primary btn-square">
            </form>
            <div class="container-fluid pt-3">
                <div class="card" style="width:fit-content;">
                    <h5 class="card-header">Your projects</h5>
                    <div class="card-body">
                        <p class="card-text">
                            <?php if ($_SESSION['role_name'] == 'Admin') : ?>
                                As admin you seee all projects in the database
                            <?php elseif ($_SESSION['role_name'] == "Project Manager") : ?>
                                All the projects that you are assigned to
                            <?php elseif ($_SESSION['role_name'] == "Developer") : ?>
                                All the projects that you are assigned to
                            <?php elseif ($_SESSION['role_name'] == "Submitter") : ?>
                                All the projects that you are assigned to
                            <?php endif ?>
                        </p>

                        <table class="table table-sm bg-light">
                            <caption>Showing first 10 users</caption>
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Description</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project) : ?>
                                    <?php $form_id = "project_details_form_" . $project['project_id'] ?>

                                    <form action="show_project_details.php" method="post" id="<?php echo $form_id ?>">
                                        <input type="hidden" name="project_id" value="<?php echo $project['project_id'] ?> ">
                                        <input type="hidden" name="project_name" value="<?php echo $project['project_name'] ?> ">
                                        <input type="hidden" name="project_description" value="<?php echo $project['project_description'] ?> ">
                                    </form>

                                    <tr>
                                        <td><?php echo $project['project_name'] ?></td>
                                        <td><?php echo $project['project_description'] ?></td>
                                        <td>
                                            <a href="#">Manage Users</a><br>
                                            <a href="#" onclick="document.getElementById('<?php echo $form_id ?>').submit()">More Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div><!-- main -->
    <?php require('templates/ui_frame_end.php'); ?>