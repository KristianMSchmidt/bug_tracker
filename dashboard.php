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
            <!-- Ticket Priority chart -->
            <canvas id="priority_chart"></canvas>
            <?php
            include('includes/db_connect.inc.php');

            $sql =
                "SELECT COUNT(tickets.ticket_id) AS count, 
                ticket_priorities.ticket_priority_name 
                FROM tickets RIGHT JOIN ticket_priorities ON tickets.priority = ticket_priorities.ticket_priority_id 
                GROUP BY ticket_priorities.ticket_priority_id ORDER BY ticket_priorities.ticket_priority_id";

            // make query and get result
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                //error message: A database error occured
                echo 'query error: ' . mysqli_error($conn);
                exit();
            }

            // fetch the resulting rows as an associative array
            $priorities = mysqli_fetch_all($result, MYSQLI_ASSOC);

            ?>
            <script>
                var ctx = document.getElementById('priority_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        /* labels: ['Low','Medium', 'High', 'Urgent'], */
                        labels: [<?php foreach ($priorities as $priority) {
                                        echo "'{$priority['ticket_priority_name']}',";
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
        </div> <!-- end of Ticket Priority chart -->

        <div>
            <!-- Ticket Status chart -->
            <canvas id="status_chart"></canvas>

            <?php


            // write query for all projects

            $sql =
                "SELECT COUNT(tickets.ticket_id) 
                AS count, ticket_status_types.ticket_status_name 
                FROM tickets RIGHT JOIN ticket_status_types 
                ON tickets.status = ticket_status_types.ticket_status_id
                GROUP BY ticket_status_types.ticket_status_id 
                ORDER BY ticket_status_types.ticket_status_id";

            // make query and get result
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                //error message: A database error occured
                echo 'query error: ' . mysqli_error($conn);
                exit();
            }

            // fetch the resulting rows as an associative array
            $statuses = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>


            <script>
                var ctx = document.getElementById('status_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Open', 'Closed', 'In Progress', 'Info Required'],
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
        </div> <!-- End of Ticket Status chart -->

        <div>
            <!-- Ticket Type chart -->
            <canvas id="type_chart"></canvas>

            <?php
            //query
            $sql =
                "SELECT 
                COUNT(tickets.ticket_id),
                ticket_types.ticket_type_name 
                FROM tickets RIGHT JOIN ticket_types ON tickets.type = ticket_types.ticket_type_id
                GROUP BY ticket_types.ticket_type_id ORDER BY ticket_types.ticket_type_id";


            // make query and get result
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                //error message: A database error occured
                echo 'query error: ' . mysqli_error($conn);
                exit();
            }


            // fetch the resulting rows as an associative array
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>


            <script>
                var ctx = document.getElementById('type_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?php foreach ($rows as $row) {
                                        echo "'{$row['ticket_type_name']}',";
                                    } ?>],

                        datasets: [{
                            label: '# of Tickets',
                            //data: [12, 19, 3, 5],
                            data: [<?php foreach ($rows as $row) {
                                        echo "'{$row['COUNT(tickets.ticket_id)']}',";
                                    } ?>],

                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(37, 116, 169, 1)',
                                'rgba(31, 58, 147, 1)',
                                'rgba(1, 50, 67, 1)'
                            ],
                            borderColor: [
                                '', '', '', '',
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
            <!-- Most Busy Users Chart -->
            <canvas id="top_busy_users_chart"></canvas>

            <?php
            //query 
            $sql =
                "SELECT COUNT(tickets.ticket_id) as count, users.username
                FROM tickets RIGHT JOIN users ON tickets.developer_assigned = users.user_id
                GROUP BY tickets.developer_assigned
                ORDER BY count(tickets.ticket_id) DESC";

            // make query and get result
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                //error message: A database error occured
                echo 'query error: ' . mysqli_error($conn);
                exit();
            }

            // fetch the resulting rows as an associative array
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <script>
                var ctx = document.getElementById('top_busy_users_chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [<?php foreach ($rows as $row) {
                                        echo "'{$row['username']}',";
                                    } ?>],

                        datasets: [{
                            label: '# T',
                            data: [<?php foreach ($rows as $row) {
                                        echo "'{$row['count']}',";
                                    } ?>],

                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            beginAtZero: true,
                            scaleLabel: {
                                labelString: 'Month'
                            },
                            ticks: {
                                stepSize: 1,
                                min: 0,
                                autoSkip: false
                            }
                        }]
                    }
                });
            </script>

            <h3>Most Busy Users (# of Tickets)</h3>
        </div> <!-- End of Most Busy Users chart -->
    </div> <!-- end of div.dashboard_wrapper -->
</div> <!-- div.main -->
</div> <!-- div.wrapper-->
</body>

</html>