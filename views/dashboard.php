<?php
include('../includes/login_check.inc.php');
include_once('../includes/auto_loader.inc.php');

$contr = new Controller();
$priorities = $contr->get_ticket_priority_count();
$statuses = $contr->get_ticket_status_count();
$types = $contr->get_tickets_type_count();
$users = $contr->get_most_busy_users();
?>

<?php include('shared/ui_frame.php'); ?>
<div class="main">
    <div class="dashboard">
        <div class="row">
            <div class="card" style="flex:1">
                <canvas id="priority_chart"></canvas>
            </div>
            <div class="card" style="flex:1">
                <canvas id="status_chart"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="card" style="flex:1">
                <canvas id="type_chart"></canvas>
            </div>

            <div class="card" style="flex:1">
                <canvas id="top_busy_users_chart"></canvas>
            </div>
        </div>
        <br><br>
    </div>
</div>

<script>
    var ctx = document.getElementById('type_chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($types as $type) {
                            echo "'{$type['ticket_type_name']}',";
                        } ?>],

            datasets: [{
                label: '# of Tickets',
                //data: [12, 19, 3, 5],
                data: [<?php foreach ($types as $type) {
                            echo "'{$type['COUNT(tickets.ticket_id)']}',";
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
            title: {
                display: true,
                text: 'Tickets by Type'
            },
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
            title: {
                display: true,
                text: 'Tickets by Status'
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


<script>
    var ctx = document.getElementById('priority_chart').getContext('2d');
    //  Chart.defaults.global.title.position = 'bottom';

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
            title: {
                display: true,
                text: 'Tickets by Priority'
            },
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

<script>
    var ctx = document.getElementById('top_busy_users_chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($users as $user) {
                            echo "'{$user['full_name']}',";
                        } ?>],

            datasets: [{
                label: '# Tickets',
                data: [<?php foreach ($users as $user) {
                            echo "'{$user['count']}',";
                        } ?>],

                backgroundColor: [
                    '#e8ffe8',
                    '#b3ffb3',
                    '#66ff66',
                    '#1aff1a',
                    '#00cc00'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Most Busy Users (# Tickets in Progress)'
            },
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

<?php include('shared/closing_tags.php') ?>

<script>
    set_active_link("dashboard");
</script>