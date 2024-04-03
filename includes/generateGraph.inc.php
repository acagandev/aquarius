<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_line.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_scatter.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_date.php');

$jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/plot.data.json');
$data = json_decode($jsonDataString, true);
$plot_data = $data['plot_data'];
$xdata = $plot_data['x_array'];
$ydata = $plot_data['y_array'];

// Refine xdata to unix timestamp
$xTimeStamp = [];
foreach ($xdata as $datetime) {
  $xTimeStamp[] = strtotime($datetime);
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

$plot = new ScatterPlot($ydata, $xTimeStamp);
$plot->value->SetMargin(10);
$plot->value->Show();
$graph->Add($plot);
$graph->Stroke($_SERVER['DOCUMENT_ROOT'] . '/profile/graph.png');

// Output buffering
ob_start();
header("Location: /profile/plotData.prf.php?jpgraph=graphGenerated");
ob_flush();
