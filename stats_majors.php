<?php
include('header.php'); 
include_once('connect.php');

// Lets get the data we need for graph.

$limit = 10;

// Grab top X most popular match majors.
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users GROUP BY major ORDER BY COUNT(major) desc LIMIT " . $limit);
$top_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

	$top_majors[$index] = $row;
    $top_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_majors[$index]['major']);
	$index++;
}

// Grab top 10 matched majors
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users WHERE matched = 1 GROUP BY major ORDER BY COUNT(major) desc LIMIT " . $limit);
$top_matched_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

    $top_matched_majors[$index] = $row;
    $top_matched_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_matched_majors[$index]['major']);
    $index++;
}

// Grab top 10 unmatched majors
$result = mysql_query("SELECT major, COUNT(major) as 'count' FROM Users WHERE matched = 0 GROUP BY major ORDER BY COUNT(major) desc LIMIT " . $limit);
$top_not_matched_majors = array();
$index = 0;
while ($row = mysql_fetch_array($result)) {

    $top_not_matched_majors[$index] = $row;
    $top_not_matched_majors[$index]['major'] = mysql_get_var("SELECT major_long FROM Majors WHERE id = " . $top_not_matched_majors[$index]['major']);
    $index++;
}



?>
<!-- Also maybe add percentages? -->


<div class="container-fluid">

    <?php include_once('stats_top.php');
    include('stats_bottom.php');
 ?> 


    <h3 class="<?php echo $heading_class_row; ?>">Top Majors by Users</h3>

    <div id="chartdiv" style="width: 100%; height: 400px;"></div>

    <h3 class="<?php echo $heading_class_row; ?>">Top Majors by Users - With Matches</h3>

    <div id="top_matched_div" style="width: 100%; height: 400px;"></div>    

    <h3 class="<?php echo $heading_class_row; ?>">Top Majors by Users - Without Matches</h3>

    <div id="top_not_matched_div" style="width: 100%; height: 400px;"></div>  

<!-- Top majors with matches, Top majors without matches -->

</div>

<script type="text/javascript">

    var topMajorsChart;

    var topMajorsChartData = [ 
	    <?php

        $max = sizeof($top_majors);

	    for ($x=0; $x<$max; $x++) {

	    	echo "\n\t{\n";
	    	echo "\t\t" . '"major": ' . '"' . $top_majors[$x]['major'] . '",' . "\n";
	    	echo "\t\t" . '"count": ' . $top_majors[$x]['count'] . "\n";
            if ($x < $max-1)
	    	echo "\t},\n";
            else
            echo "\t}\n";
	    } ?>
    ];

    var topMatchedMajorsChart;

    var topMatchedMajorsChartData = [ 
        <?php

        $max = sizeof($top_matched_majors);

        for ($x=0; $x<$max; $x++) {

            echo "\n\t{\n";
            echo "\t\t" . '"major": ' . '"' . $top_matched_majors[$x]['major'] . '",' . "\n";
            echo "\t\t" . '"count": ' . $top_matched_majors[$x]['count'] . "\n";
            if ($x < $max-1)
            echo "\t},\n";
            else
            echo "\t}\n";
        } ?>
    ];

    var topNotMatchedMajorsChart;

    var topNotMatchedMajorsChartData = [ 
        <?php

        $max = sizeof($top_not_matched_majors);

        for ($x=0; $x<$max; $x++) {

            echo "\n\t{\n";
            echo "\t\t" . '"major": ' . '"' . $top_not_matched_majors[$x]['major'] . '",' . "\n";
            echo "\t\t" . '"count": ' . $top_not_matched_majors[$x]['count'] . "\n";
            if ($x < $max-1)
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
            topMatchedMajorsChart.rotate = true;
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
            topNotMatchedMajorsChart.rotate = true;
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
            topMajorsChart.rotate = true;
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