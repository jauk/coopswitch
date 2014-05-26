<?php include('header.php'); ?>

<div class="container-fluid">

    <div class="row-fluid text-center">

    <hr />

    <div class="row-fluid text-center">
        <h1>Statistics</h1>
        <p class="lead">Statistics will provide SCDC with valuable information on student behaviors.</p>
    </div>

    <!-- Should do a survey seeing top reasons people want to switch cycle and cross-ref that.
            Ie. Maybe people from X country choose Y major and need Z cycle for whatever reason.
     -->

    <div class="row-fluid col-md-4 col-md-offset-4 text-center">
        <ul class="nav nav-justified">
            <li><button onclick="location.href='stats_majors.php'" type="button" class="btn btn-lg btn-info">Majors</button></li>
            <li><button onclick="location.href='stats_matches.php'" type="button" class="btn btn-lg btn-info">Matches</button></li>
    <!--    <li><a href="stats_coops.php">Cycles by Major</a></li>
            <li><a href="stats_switches.php">Popular Switches</a></li> -->
        </ul>
    </div>

    </div>

<!-- Major specific stats for everything 
     Get as specific as possible, enter major to get stats for, etc.
     Make line graphs that go over time, etc. (ADD MATCHED DATE COLUMN TO Matches TABLE FOR THIS TOO)
-->


</div>

<?php include('footer.php'); ?>