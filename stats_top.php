<?php if (!stripos($_SERVER['REQUEST_URI'], 'stats.php')) { ?>
<br><hr>
<?php } ?> 

 <div class="row-fluid text-center">
        <h1>Statistics</h1>
        <p class="lead">Statistics will provide SCDC with valuable information on student behaviors.</p>
        <br>
    </div>

    <!-- Should do a survey seeing top reasons people want to switch cycle and cross-ref that.
            Ie. Maybe people from X country choose Y major and need Z cycle for whatever reason.
     -->

    <div class="row-fluid col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 text-center">
        <ul class="nav nav-justified">
            <li><button onclick="location.href='stats_majors.php'" type="button" class="btn btn-lg btn-info">Majors</button></li>
            <li><button onclick="location.href='stats_matches.php'" type="button" class="btn btn-lg btn-info">Matches</button></li>
            <li><button onclick="location.href='#'" type="button" class="btn btn-lg btn-info">Other</button></li>
            <?php if (!stripos($_SERVER['REQUEST_URI'], 'stats.php')) { ?>
            <li><button onclick="location.href='stats.php'" type="button" class="btn btn-lg btn-info">Back</button></li>
            <?php } ?> 
        </ul>
    </div>

    <?php if (!stripos($_SERVER['REQUEST_URI'], 'stats.php')) { ?>
    <br><br><hr>
    <?php } ?> 