<?php
use kandopanel\reportController;
$report = new reportController();
$report->range  = isset($_GET['range']) ? $_GET['range'] : '7day';
$report->output_report();

