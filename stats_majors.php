<?php
include('header.php'); 
include_once('connect.php');
// Lets get the data we need for graph.


// Grab top 10 most popular match majors.
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users GROUP BY major ORDER BY COUNT(major) desc LIMIT 10");

$top_majors = array();

// Skipping top major for some reason

$index = 0;
while ($row = mysql_fetch_array($result)) {

	$top_majors[$index] = $row;
    $top_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_majors[$index]['major']);
	$index++;
}

?>


<?php include_once('statstop.php'); ?>

<script src="../amcharts/amcharts.js" type="text/javascript"></script>
<script src="../amcharts/serial.js" type="text/javascript"></script>

<div class="container-fluid">

<a href="stats.php">Back</a>

<h1>Most Popular Majors</h1>

<!-- Also maybe add percentages? -->

<div id="chartdiv" style="width: 100%; height: 400px;"></div>


</div>

<script type="text/javascript">

    var chart;

    var chartData = [ 
	    <?php

	    for ($x=0; $x<9; $x++) {

	    	echo "\n\t{\n";
	    	echo "\t\t" . '"major": ' . '"' . $top_majors[$x]['major'] . '",' . "\n";
	    	echo "\t\t" . '"count": ' . $top_majors[$x]['count'] . "\n";
            if ($x < 8)
	    	echo "\t},\n";
            else
            echo "\t}\n";

	    }

	    ?>
    ];

    AmCharts.ready(function () {
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData;
        chart.categoryField = "major";
        chart.startDuration = 1;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
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
        chart.addGraph(graph);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "top-right";

        chart.write("chartdiv");
    });
</script>

<?php
include('footer.php');
?>