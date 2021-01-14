<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
include_once('../includes/auto_loader.inc.php');

$contr = new Controller();
$priorities = $contr->get_ticket_priority_count();
$statuses = $contr->get_ticket_status_count();
$types = $contr->get_tickets_type_count();
$users = $contr->get_most_busy_users();
?>

<div class="main">
    <div class="layout">
        <div class="row">
            <div class="card" style="flex:1">
                <canvas id="priority_chart"></canvas>
            </div>

            <div class="card" style="flex:1">
                <canvas id="pt"></canvas>
            </div>
        </div>

        <div class="row">

            <div class="card" style="flex:1">
                <canvas id="ptxx"></canvas>
            </div>

            <div class="card" style="flex:1">
                <canvas id="y" style="background-color:white"></canvas>
            </div>

        </div>

    </div>
</div>


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
    var ctx = document.getElementById('ptxx').getContext('2d');
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
    var ctx = document.getElementById('pt').getContext('2d');
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
    var ctx = document.getElementById('y').getContext('2d');
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
<?php include('shared/closing_tags.php') ?>