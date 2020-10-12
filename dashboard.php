<?php
require "templates/ui_frame.php";

if (!isset($_SESSION['username'])) {
    //if user is not logged in, redirect to login page
    header('location: login.php');
    exit();
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>


<div class="main">
    <div class="dashboard_wrapper">

        <div>
            <!-- priority chart -->
            <canvas id="priority_chart"></canvas>


            <?php
            include('includes/db_connect.inc.php');

            // write query for all projects

            $sql =
                "SELECT 
            COUNT(tickets.ticket_id) AS count, 
    
            ticket_priorities.priority_name 
            FROM tickets RIGHT JOIN ticket_priorities ON tickets.priority = ticket_priorities.priority_id 
            GROUP BY ticket_priorities.priority_id ORDER BY ticket_priorities.priority_id";


            // make query and get result
            $result = mysqli_query($conn, $sql);

            // fetch the resulting rows as an associative array
            $priorities = mysqli_fetch_all($result, MYSQLI_ASSOC);

            ?>
            <script>
                var ctx = document.getElementById('priority_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        /* labels: ['None','Low','Medium', 'High'], */

                        labels: [<?php foreach ($priorities as $priority) {
                                        echo "'{$priority['priority_name']}',";
                                    } ?>],

                        datasets: [{
                            label: '# of Tickets',
                            /* data: [12, 19, 3, 5], */

                            data: [<?php foreach ($priorities as $priority) {
                                        echo "'{$priority['count']}',";
                                    } ?>],

                            backgroundColor: [
                                'rgba(255, 148, 120, 1)',
                                'rgba(242, 38, 19, 1)',
                                'rgba(217, 30, 24, 1)',
                                'rgba(150, 40, 27, 1)',
                            ],

                            borderColor: [
                                '',
                                '',
                                '',
                                '',
                            ],

                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },

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
            <h3>Tickets by Priority</h3>
        </div> <!-- end of priority chart -->


        <div>
            <!-- Ticket XX chart -->
            <canvas id="XX_chart"></canvas>

            <script>
                var ctx = document.getElementById('XX_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['A', 'B', 'C', 'D'],

                        datasets: [{
                            label: '# of Tickets',
                            data: [12, 19, 3, 5],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                        }]
                    },
                });
            </script>

            <h3>Tickets XX Status</h3>
        </div> <!-- Ticket XX chart -->

        <div>
            <!-- Ticket Type chart -->
            <canvas id="type_chart"></canvas>

            <?php


            // write query for all projects

            $sql =
                "SELECT
        COUNT(tickets.ticket_id) AS count,

        ticket_types.ticket_type_name
        FROM tickets RIGHT JOIN ticket_types ON tickets.ticket_type = ticket_types.ticket_type_id
        GROUP BY ticket_types.ticket_type_id ORDER BY ticket_types.ticket_type_id";


            // make query and get result
            $result = mysqli_query($conn, $sql);

            // fetch the resulting rows as an associative array
            $types = mysqli_fetch_all($result, MYSQLI_ASSOC);

            ?>

            <script>
                var ctx = document.getElementById('type_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        //labels: ['Feature Request', 'Bugs/Errors', 'Others Comments'],
                        labels: [<?php foreach ($types as $type) {
                                        echo "'{$type['ticket_type_name']}',";
                                    } ?>],

                        datasets: [{
                            label: '# of Tickets',
                            //data: [12, 19, 3, 5],
                            data: [<?php foreach ($types as $type) {
                                        echo "'{$type['count']}',";
                                    } ?>],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(37, 116, 169, 1)',
                                'rgba(31, 58, 147, 1)',
                                'rgba(1, 50, 67, 1)'
                            ],
                            borderColor: [
                                '', '', '',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
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

            <h3>Tickets by Type</h3>
        </div> <!-- End of Ticket Type Chart -->


        <div>
            <!-- Ticket Status chart -->
            <canvas id="status_chart"></canvas>

            <?php


            // write query for all projects

            $sql =
                "SELECT COUNT(tickets.ticket_id) 
            AS count, ticket_status_types.status 
            FROM tickets RIGHT JOIN ticket_status_types 
            ON tickets.status = ticket_status_types.ticket_status_id
            GROUP BY ticket_status_types.ticket_status_id 
            ORDER BY ticket_status_types.ticket_status_id";


            // make query and get result
            $result = mysqli_query($conn, $sql);

            // fetch the resulting rows as an associative array
            $statuses = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>


            <script>
                var ctx = document.getElementById('status_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Open', 'Closed', 'In Progress', 'More Info Required'],
                        /* labels: [<?php foreach ($statuses as $status) {
                                        echo "'{$status['status']}',";
                                    } ?>],*/

                        datasets: [{
                            label: '# of Tickets',
                            //data: [12, 19, 3, 10],
                            data: [<?php foreach ($statuses as $status) {
                                        echo "'{$status['count']}',";
                                    } ?>],

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
                        legend: {
                            display: false
                        },
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

            <h3>Tickets by Status</h3>
        </div> <!-- Ticket Status chart -->


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

            <h3>Rod</h3>
        </div>
    </div><!-- DashBoard Wrapper     -->
</div><!-- end of main-->


<?php
require 'templates/footer.php';

?>