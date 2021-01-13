<?php
include('../includes/login_check.inc.php');
include('shared/ui_frame.php');
include_once('../includes/auto_loader.inc.php');

$ticket_model = new Tickets();
$priorities = $ticket_model->get_ticket_priority_count();
$statuses = $ticket_model->get_ticket_status_count();
$types = $ticket_model->get_tickets_type_count();
$ticket_model = null; //would get deleted automatically anyway after end of script.
$user_model = new Users();
$users = $user_model->get_most_busy_users();
?>


<style>
    alko {
        width: 120px;
        height: 20px;
        position: relative;
        background: blue;

    }

    canvas {
        width: 80%;
        height: 80%;
    }
</style>


<div class="main layout">

    <div class=row style="background-color:aquamarine;">
        <div class="col alko" style="background-color:blue">
            <canvas id="priority_chart" style="background-color:green"></canvas>
        </div>

        <div class="col alko">
            <canvas id="pt" style="background-color:green"></canvas>
        </div>
    </div>
    <div class=row style="background-color:brown">
        <div class="col alko" style="background-color:blue">
            <canvas id="ptxx" style="background-color:white"></canvas>
        </div>
        <div class="col alko" style="background-color:blue">
            <canvas id="y" style="background-color:white    "></canvas>
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

<script>
    var canvas = document.getElementById('priority_chart');
    fitToContainer(canvas);

    var canvas = document.getElementById('y');
    fitToContainer(canvas);

    var canvas = document.getElementById('pt');
    fitToContainer(canvas);

    var canvas = document.getElementById('ptxx');
    fitToContainer(canvas);

    function fitToContainer(canvas) {
        // Make it visually fill the positioned parent
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        // ...then set the internal size to match
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
</script>


<?php include('shared/closing_tags.php') ?>