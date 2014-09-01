<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/config.php");
require_once(TEMPLATES_PATH . "/header.php"); 
include(FUNCTION_PATH . "/connect.php");
// Lets get the data we need for graph.

//$limit = 10;

// Data for bar graph
// Grab top 10 most popular match majors that have matches.
$result = mysql_query("SELECT * FROM Matches");
$matches = array();

$dataArray = array();
$dateFormat = "Y-m-d";

// Should proably do total matches, not just matches on each day.
// Also have the % of students matched line somewhere. 

// Should probably redo this with sql statement, be a lot easier. WHERE date = blah, export rows as count.
// Could send major id to Matches db too for major-specific w/e stats.   

// Matches over time vs total users

$initDate = false;

$index = 0;
$newDay = 0;
while ($row = mysql_fetch_array($result)) {

    $matches[$index] = $row;

    if (!$initDate) {

        $date = $matches[$index]['date_matched'];
        $date = date($dateFormat, strtotime($date));

        $initDate = true;
    }

    if ($date != date($dateFormat, strtotime($matches[$index]['date_matched']))) { 
        $newDay++;

        $date = $matches[$index]['date_matched'];
        $date = date($dateFormat, strtotime($date));
    }

    $dataArray[$newDay]['date'] = $date;

    if (!isset($dataArray[$newDay]['count']))
        $dataArray[$newDay]['count'] = 1;
    else
        $dataArray[$newDay]['count'] += 1;
}

for ($x=0; $x<sizeof($dataArray); $x++) {

    echo $dataArray[$x]['date'] . " " . $dataArray[$x]['count'] . "<br>"; 
}

// $heading_class_row = "row-fluid col-md-8 col-md-offset-1";

?>


<?php require_once(TEMPLATES_PATH . "/stats_top.php"); ?>

<div class="container-fluid">

    <h3 class="<?php echo $heading_class_row; ?>">Matches Over Time</h3>

    <!-- Also maybe add percentages? -->

    <div id="chartdiv" style="width: 100%; height: 400px;"></div>

    <?php
            $count = 0;
    ?>
    </div>

    <script type="text/javascript">

        var chart;

        window.chartData = [ 
            <?php

            $max = sizeof($dataArray);


            // for ($x=1; $x<$max; $x++) {

            for ($x=0; $x<sizeof($dataArray); $x++) {

              //  $count += $matches_dates[$x]['count'];

                echo "\n\t{\n";
                echo "\t\t" . '"count": ' . '"' . $dataArray[$x]['count'] . '",' . "\n";
                echo "\t\t" . '"day": ' . $dataArray[$x]['date'] . "\n";
                if ($x < $max-1)
                echo "\t},\n";
                else
                echo "\t}\n";

            }

            ?>
        ];

var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "none",
    "marginLeft": 20,
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "dataProvider": window.chartData,
    "valueAxes": [{
        "axisAlpha": 0,
        "inside": true,
        "position": "left",
        "ignoreAxisWidth": true
    }],
    "graphs": [{
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
        "bullet": "round",
        "bulletSize": 6,
        "lineColor": "#d1655d",
        "lineThickness": 2,
        "negativeLineColor": "#637bb6",
        "type": "smoothedLine",
        "valueField": "value"
    }],
    "chartScrollbar": {},
    "chartCursor": {
        "categoryBalloonDateFormat": "YYYY",
        "cursorAlpha": 0,
        "cursorPosition": "mouse"
    },
    "dataDateFormat": "YYYY",
    "categoryField": "year",
    "categoryAxis": {
        "minPeriod": "YYYY",
        "parseDates": true,
        "minorGridAlpha": 0.1,
        "minorGridEnabled": true
    }
});



    </script>

<?php
require_once(TEMPLATES_PATH . "/footer.php"); 
?>
