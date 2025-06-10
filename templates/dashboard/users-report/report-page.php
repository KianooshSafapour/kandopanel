<?php

use kandopanel\ureportController;

$report = new ureportController();
$report->range  = isset($_GET['range']) ? $_GET['range'] : 'today';
$report->output_report();

