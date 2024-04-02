<?php // content="text/plain; charset=utf-8"
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/jpgraph/jpgraph_line.php');

// Some data
$ydata = array(1, 3, 4, 2, -1, -3, 1, 0, 4, 3);

// Create the graph. These two calls are always required
$graph = new Graph(350, 250);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot = new LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// $img = "temp";
// Display the graph
$graph->Stroke($_SERVER['DOCUMENT_ROOT'] . '/img/graph/graph.png');
