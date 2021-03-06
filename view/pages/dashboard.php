<?php
require_once('../../control/shared/login_check.inc.php');
require_once('../../control/controller.class.php');

$contr = new Controller();
$priorities = $contr->get_ticket_priority_count();
$statuses = $contr->get_ticket_status_count();
$types = $contr->get_tickets_type_count();
$users = $contr->get_most_busy_users();
?>

<?php require('page_frame/ui_frame.php'); ?>

<div class="main">
    <div class="dashboard">
        <div class="row">
            <div class="card">
                <canvas id="priority_chart"></canvas>
            </div>
            <div class="card">
                <canvas id="status_chart"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <canvas id="type_chart"></canvas>
            </div>

            <div class="card">
                <canvas id="top_busy_users_chart"></canvas>
            </div>
        </div>
        <br><br>
    </div>
</div>

<!-- JS chart library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>

<script>
    /* Ticket Status Chart */
    var ctx = document.getElementById('status_chart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Open', 'Closed', 'In Progress', 'Info Required'],
            /*  [<?php foreach ($statuses as $status) {
                        echo "'{$status['ticket_status_name']}',";
                    } ?>], */

            datasets: [{
                label: '# of Tickets',

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

    /* Ticket Priority Chart */
    var ctx = document.getElementById('priority_chart').getContext('2d');

    var priorityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            /* labels: ['Low','Medium', 'High', 'Urgent'], */
            labels: [<?php foreach ($priorities as $priority) {
                            echo "'{$priority['ticket_priority_name']}',";
                        } ?>],

            datasets: [{
                label: '# of Tickets',
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

    /* Ticket Type Chart */
    var ctx = document.getElementById('type_chart').getContext('2d');
    var typeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($types as $type) {
                            echo "'{$type['ticket_type_name']}',";
                        } ?>],

            datasets: [{
                label: '# of Tickets',

                data: [<?php foreach ($types as $type) {
                            echo "'{$type['COUNT(tickets.id)']}',";
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
            },
        }
    });

    /*Busy Users Chart */
    var ctx = document.getElementById('top_busy_users_chart').getContext('2d');
    var Chart = new Chart(ctx, {
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


<?php require('page_frame/closing_tags.php') ?>

<script>
    set_active_link("dashboard");
</script>