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
    .dashboard_wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        /*gap: 1em;*/
        background-color: greenyellow;
        align-items: stretch;
    }

    .card {
        padding: 0.5em;
        padding-left: 4.5em;
        padding-right: 4.5em;
        margin: 1em;
    }

    @media only screen and (max-width: 700px) {
        .dashboard_wrapper {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr 1fr 1fr;
        }
    }
</style>
<div class="main">

    <div class="dashboard_wrapper">
        <div card-holder>
            <div class="card">
                <canvas id="priority_chart"></canvas>
            </div>
        </div>
        <div class="card">
            <canvas id="pt"></canvas>
        </div>
        <div>
            <div class="card">
                <canvas id="ptxx"></canvas>
            </div>
        </div>
        <div>
            <div class="card">
                <canvas id="y" style="background-color:white"></canvas>
            </div>
        </div>

    </div>

    <?php include('shared/closing_tags.php') ?>


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