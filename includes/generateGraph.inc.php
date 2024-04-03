<?php
require($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph.php');
require($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_line.php');

$jsonDataString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/json/plot.data.json');
$data = json_decode($jsonDataString, true);
$plot_data = $data['plot_data'];
$xdata = $plot_data['x_array'];
$ydata = $plot_data['y_array'];

// Debug...
// echo implode(',', $xdata);
// echo nl2br("\n");
// echo implode(',', $ydata);
// echo nl2br("\n");

// Width and height of the graph
$width = 600;
$height = 200;

// Create a graph instance
$graph = new Graph($width, $height);

// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint', 0, 0, 0, max($xdata) - min($xdata) + 1);

// Setup a title for the graph
$graph->title->Set('Sunspot example');

// Setup titles and X-axis labels
$graph->xaxis->title->Set('(year from 1701)');

// Setup Y-axis title
$graph->yaxis->title->Set('(# sunspots)');

// Create the linear plot
$lineplot = new LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke($_SERVER['DOCUMENT_ROOT'] . '/profile/graph.png');
ob_start();
header("Location: /dataTransfer.php?jpgraph=graphGenerated");
ob_flush();
