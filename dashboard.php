<?php
require "templates/ui_frame.php";

if (!isset($_SESSION['username'])) {
    //if user is not logged in, redirect to login page
    header('location: login.php');
    exit();
}

?>

<div class="main">

    <style>
        .dashboard_wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            border: 1px solid black;
            padding-top: 1em;
            gap: 1em;
            padding-bottom: 0;
            margin: 0;
        }

        .hidden {
            display: none;
        }

        .dashboard_wrapper>div {
            border: 1px solid red;
            padding: 0em;
            width: 30em;
            height: 15em;
            background-color: lightgray;
            ;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>


    <div class="dashboard_wrapper">
        <div>
            <canvas id="priority_chart"></canvas>

            <script>
                var ctx = document.getElementById('priority_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['None', 'Low', 'Medium', 'High'],
                        datasets: [{
                            label: '# of Tickets',
                            data: [12, 19, 3, 5],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>
            Tickets by Priority
        </div>



        <div>
            <div>
                <canvas id="status_chart"></canvas>

                <script>
                    var ctx = document.getElementById('status_chart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['None', 'Low', 'Medium', 'High'],
                            datasets: [{
                                label: '# of Tickets',
                                data: [12, 19, 3, 5],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>

                Tickets by Type
            </div>
        </div>
        <div>Tickets by Status</div>
        <div>
            <form action="show_users.php">
                <input type="submit" name="show_users_submit" value="show users"><br>
            </form><br>

            <form action="show_projects.php">
                <input type="submit" name="show_projects_submit" value="show projects"><br>
            </form><br>

            <form action="show_tickets.php">
                <input type="submit" name="show_tickets_submit" value="show tickets"><br>
            </form><br>

            <form action='includes/logout.inc.php' type='POST' style="display:inline-block">
                <input type="submit" name="logout_submit" value="LOG OUT">
            </form>
        </div>
    </div>


    <?php
    require 'templates/footer.php';

    ?>