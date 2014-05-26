<?php
include('header.php'); 
include_once('connect.php');
// Lets get the data we need for graph.

// Data for bar graph
// Grab top 10 most popular match majors that have matches.
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users WHERE matched = 1 GROUP BY major ORDER BY COUNT(major) desc LIMIT 10");
$top_matches = array();

$index = 0;
while ($row = mysql_fetch_array($result)) {

	$top_matches[$index] = $row;
    $top_matches[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_matches[$index]['major']);
	$index++;
}

// Data for pie chart
// Grab the # of people matched and number of people in db. Not matched = peopleInDB - peopleMatched.

// Get all the peoples matched (copied from check.php and modified)
$query="SELECT * FROM Users WHERE matched = 1";
$result=mysql_query($query);
$num_users_matched = mysql_num_rows($result);

$query="SELECT * FROM Users WHERE matched = 0";
$result=mysql_query($query);
$num_users_not_matched = mysql_num_rows($result);


$heading_class_row = "row-fluid col-md-8 col-md-offset-1";

?>


<?php include_once('statstop.php'); ?>

<script src="../amcharts/amcharts.js" type="text/javascript"></script>
<script src="../amcharts/serial.js" type="text/javascript"></script>
<script src="../amcharts/pie.js" type="text/javascript"></script>


<div class="container-fluid">

<a href="stats.php">Back</a><br>

<h1 class="<?php echo $heading_class_row; ?>">Top Matches by Major</h1>

<!-- Also maybe add percentages? -->

<div id="chartdiv" style="width: 100%; height: 400px;"></div>

<h1 class="<?php echo $heading_class_row; ?>">Percentage of Users Matched</h1>

<div id="piechartdiv" style="width: 100%; height: 400px;"></div>

</div>

<script type="text/javascript">

    
    var pieChart;

    var pieChartData = [

            {
                "status": "Matched",
                "value":  <?php echo $num_users_matched; ?>
            },
            {
                "status": "Not Matched",
                "value":  <?php echo $num_users_not_matched; ?>
            }
    ];




    var chart;

    var chartData = [ 
	    <?php

	    for ($x=0; $x<9; $x++) {

	    	echo "\n\t{\n";
	    	echo "\t\t" . '"major": ' . '"' . $top_matches[$x]['major'] . '",' . "\n";
	    	echo "\t\t" . '"count": ' . $top_matches[$x]['count'] . "\n";
            if ($x < 8)
	    	echo "\t},\n";
            else
            echo "\t}\n";

	    }

	    ?>
    ];



    AmCharts.ready(function () {

        pieChart = new AmCharts.AmPieChart();
        pieChart.dataProvider = pieChartData;
        pieChart.titleField = "status";
        pieChart.valueField = "value";
        pieChart.outlineColor = "#FFFFFF";
        pieChart.outlineAlpha = 0.8;
        pieChart.outlineThickness = 2;
        pieChart.creditsPosition = "top-right";

        // WRITE
        pieChart.write("piechartdiv");
    });

    // For bar graph
    AmCharts.ready(function () {

        // Bar Graph Chart
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