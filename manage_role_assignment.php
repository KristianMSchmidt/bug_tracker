<?php
require "templates/ui_frame.php";

if (!isset($_SESSION['username'])) {
    //if user is not logged in, redirect to login page
    header('location: login.php');
    exit();
}
?>

<style>
    .mur_wrapper {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-template-rows: 1fr 1fr;
        padding-right: 0em;
        padding-top: 1em;
        padding-bottom: 0em;
        padding-left: 6em;
        gap: 1em;
        margin: 0em;
        float: center;
        border: solid green;
    }

    .mur_wrapper>div {
        border: 1px solid black;
    }


    .main {
        border: solid black;
    }
</style>

<div class="main">

    <div class="mur_wrapper">
        <h1>manage...</h1>
        <div>One</div>
        <div>Two</div>
        <div class="xx">
            <nav>
                <ul>
                    <p>a</p>
                    <p>b</p>
                    <a href="#">c</a>
                    <li>b</li>
                    <li>c</li>
                </ul>
            </nav>

        </div>
        <div>rewew</div>
    </div><!-- end of mur_wrapper -->
</div><!-- main.div -->
</div>
<!--div.wrapper-->
</body>

</html>