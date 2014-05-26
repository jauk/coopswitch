<?php
include('header.php'); 
include_once('connect.php');
// Lets get the data we need for graph.


// Grab top 10 most popular match majors.
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users GROUP BY major ORDER BY COUNT(major) desc LIMIT 10");
$top_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

	$top_majors[$index] = $row;
    $top_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_majors[$index]['major']);
	$index++;
}

// Grab top 10 matched majors
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users WHERE matched = 1 GROUP BY major ORDER BY COUNT(major) desc LIMIT 10");
$top_matched_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

    $top_matched_majors[$index] = $row;
    $top_matched_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_matched_majors[$index]['major']);
    $index++;
}

// Grab top 10 unmatched majors
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users WHERE matched = 0 GROUP BY major ORDER BY COUNT(major) desc LIMIT 10");
$top_not_matched_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

    $top_not_matched_majors[$index] = $row;
    $top_not_matched_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_not_matched_majors[$index]['major']);
    $index++;
}


$heading_class_row = "row-fluid col-md-8 col-md-offset-1";

?>
<!-- Also maybe add percentages? -->


<script src="../amcharts/amcharts.js" type="text/javascript"></script>
<script src="../amcharts/serial.js" type="text/javascript"></script>

<div class="container-fluid">

    <a href="stats.php">Back</a><br>

    <h1 class="<?php echo $heading_class_row; ?>">Top Majors by Users</h1>

    <div id="chartdiv" style="width: 100%; height: 400px;"></div>

    <h1 class="<?php echo $heading_class_row; ?>">Top Majors by Users - With Matches</h1>

    <div id="top_matched_div" style="width: 100%; height: 400px;"></div>    

    <h1 class="<?php echo $heading_class_row; ?>">Top Majors by Users - Without Matches</h1>

    <div id="top_not_matched_div" style="width: 100%; height: 400px;"></div>  

<!-- Top majors with matches, Top majors without matches -->

</div>

<script type="text/javascript">

    var topMajorsChart;

    var topMajorsChartData = [ 
	    <?php

	    for ($x=0; $x<9; $x++) {

	    	echo "\n\t{\n";
	    	echo "\t\t" . '"major": ' . '"' . $top_majors[$x]['major'] . '",' . "\n";
	    	echo "\t\t" . '"count": ' . $top_majors[$x]['count'] . "\n";
            if ($x < 8)
	    	echo "\t},\n";
            else
            echo "\t}\n";
	    } ?>
    ];

    var topMatchedMajorsChart;

    var topMatchedMajorsChartData = [ 
        <?php

        for ($x=0; $x<9; $x++) {

            echo "\n\t{\n";
            echo "\t\t" . '"major": ' . '"' . $top_matched_majors[$x]['major'] . '",' . "\n";
            echo "\t\t" . '"count": ' . $top_matched_majors[$x]['count'] . "\n";
            if ($x < 8)
            echo "\t},\n";
            else
            echo "\t}\n";
        } ?>
    ];

    var topNotMatchedMajorsChart;

    var topNotMatchedMajorsChartData = [ 
        <?php

        for ($x=0; $x<9; $x++) {

            echo "\n\t{\n";
            echo "\t\t" . '"major": ' . '"' . $top_not_matched_majors[$x]['major'] . '",' . "\n";
            echo "\t\t" . '"count": ' . $top_not_matched_majors[$x]['count'] . "\n";
            if ($x < 8)
            echo "\t},\n";
            else
            echo "\t}\n";
        } ?>
    ];

        AmCharts.ready(function () {
            // SERIAL CHART
            topMatchedMajorsChart = new AmCharts.AmSerialChart();
            topMatchedMajorsChart.dataProvider = topMatchedMajorsChartData;
            topMatchedMajorsChart.categoryField = "major";
            topMatchedMajorsChart.startDuration = 1;

            // AXES
            // category
            var categoryAxis = topMatchedMajorsChart.categoryAxis;
            categoryAxis.labelRotation = 60;
            categoryAxis.gridPosition = "start";

            // value
            // in case you don't want to change default settings of value axis,
            // you don't need to create it, as one value axis is created automatically.

            // GRAPH
            var graph = new AmCharts.AmGraph();
            graph.valueField = "count";
            graph.balloonText = "[[category]]: <b>[[value]]</b>";
            graph.type = "column";
            graph.lineAlpha = 0;
            graph.fillAlphas = 0.8;
            topMatchedMajorsChart.addGraph(graph);

            // CURSOR
            var chartCursor = new AmCharts.ChartCursor();
            chartCursor.cursorAlpha = 0;
            chartCursor.zoomable = false;
            chartCursor.categoryBalloonEnabled = false;
            topMatchedMajorsChart.addChartCursor(chartCursor);

            topMatchedMajorsChart.creditsPosition = "top-right";

            topMatchedMajorsChart.write("top_matched_div");
        });

        AmCharts.ready(function () {
            // SERIAL CHART
            topNotMatchedMajorsChart = new AmCharts.AmSerialChart();
            topNotMatchedMajorsChart.dataProvider = topNotMatchedMajorsChartData;
            topNotMatchedMajorsChart.categoryField = "major";
            topNotMatchedMajorsChart.startDuration = 1;

            // AXES
            // category
            var categoryAxis = topNotMatchedMajorsChart.categoryAxis;
            categoryAxis.labelRotation = 60;
            categoryAxis.gridPosition = "start";

            // value
            // in case you don't want to change default settings of value axis,
            // you don't need to create it, as one value axis is created automatically.

            // GRAPH
            var graph = new AmCharts.AmGraph();
            graph.valueField = "count";
            graph.balloonText = "[[category]]: <b>[[value]]</b>";
            graph.type = "column";
            graph.lineAlpha = 0;
            graph.fillAlphas = 0.8;
            topNotMatchedMajorsChart.addGraph(graph);

            // CURSOR
            var chartCursor = new AmCharts.ChartCursor();
            chartCursor.cursorAlpha = 0;
            chartCursor.zoomable = false;
            chartCursor.categoryBalloonEnabled = false;
            topNotMatchedMajorsChart.addChartCursor(chartCursor);

            topNotMatchedMajorsChart.creditsPosition = "top-right";

            topNotMatchedMajorsChart.write("top_not_matched_div");
        });

        AmCharts.ready(function () {
            // SERIAL CHART
            topMajorsChart = new AmCharts.AmSerialChart();
            topMajorsChart.dataProvider = topMajorsChartData;
            topMajorsChart.categoryField = "major";
            topMajorsChart.startDuration = 1;

            // AXES
            // category
            var categoryAxis = topMajorsChart.categoryAxis;
            categoryAxis.labelRotation = 60;
            categoryAxis.gridPosition = "start";

            // value
            // in case you don't want to change default settings of value axis,
            // you don't need to create it, as one value axis is created automatically.

            // GRAPH
            var graph = new AmCharts.AmGraph();
            graph.valueField = "count";
            graph.balloonText = "[[category]]: <b>[[value]]</b>";
            graph.type = "column";
            graph.lineAlpha = 0;
            graph.fillAlphas = 0.8;
            topMajorsChart.addGraph(graph);

            // CURSOR
            var chartCursor = new AmCharts.ChartCursor();
            chartCursor.cursorAlpha = 0;
            chartCursor.zoomable = false;
            chartCursor.categoryBalloonEnabled = false;
            topMajorsChart.addChartCursor(chartCursor);

            topMajorsChart.creditsPosition = "top-right";

            topMajorsChart.write("chartdiv");
        });

</script>

<?php
include('footer.php');
?>