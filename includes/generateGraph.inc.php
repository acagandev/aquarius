<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/graphTypes.class.php');

$graphType = new GraphTypes;
$graphType->scatter();

header("Location: /profile/viewData.prf.php?jpgraph=graphGenerated");
