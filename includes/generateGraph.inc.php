<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_line.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_scatter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_date.php');

$jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/graph.data.json');
$jsonData = json_decode($jsonDataString, true);
$plotData = $jsonData['graph_data'];
$xData = $plotData['x_array'];
$yData = $plotData['y_array'];

// Convert xData to unix timestamp
$xTimeStamp = [];
foreach ($xData as $dateTime) {
  $xTimeStamp[] = strtotime($dateTime);
}

$width = 1200;
$height = 350;

$graph = new Graph($width, $height, "auto");
$graph->img->SetMargin(110, 20, 35, 105);
$graph->SetScale('datlin');

$graph->xaxis->SetTickLabels($xTimeStamp);
$graph->xaxis->HideFirstTicklabel();
$graph->xaxis->SetLabelAngle(35);
$graph->yaxis->SetTitleMargin(50);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");

$graph->title->Set('Temperature');

// $graph->xaxis->title->Set('');

$graph->yaxis->title->Set('deg C');

$plot = new ScatterPlot($yData, $xTimeStamp);
$plot->value->SetMargin(10);
$plot->value->Show();
$graph->Add($plot);
$graph->Stroke($_SERVER['DOCUMENT_ROOT'] . '/profile/graph.png');

// Output buffering
ob_start();
header("Location: /profile/viewData.prf.php?jpgraph=graphGenerated");
ob_flush();
