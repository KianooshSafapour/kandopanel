<?php
/*
Template Name: cron page
*/

use samyar\cronController;
$cron_order = 0;
$cron_status = 0;
$cron_multi_status = 0;
$cron_update = 0;
$cron_refill_order = 0;
$cron_refill_status = 0;
$cron_dripfeed = 0;
$cron_subscriptions = 0;
//$key = get_query_var( 'key', false );
//$cron_order = get_query_var( 'kando-cron-order', false );
//$cron_status = get_query_var( 'kando-cron-status', false );
$cronjob_key = get_option('cronjob_key');
$cron =cronController::getInstance();

$key = isset($_GET['key']) && $_GET['key'] ?$_GET['key']: "";


if(isset($_GET['type']) && $_GET['type'] === "order") {
    $cron_order = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "status") {
    $cron_status = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "multi_status") {
    $cron_multi_status = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "update") {
    $cron_update = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "refill_order") {
    $cron_refill_order = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "refill_status") {
    $cron_refill_status = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "dripfeed") {
	$cron_dripfeed = 1;
}

if(isset($_GET['type']) && $_GET['type'] === "subscriptions") {
    $cron_subscriptions = 1;
}

if(isset($key, $cronjob_key) && $cron_order && !empty($cronjob_key) && $cronjob_key === $key){

    $cron->cron('order');

}

if(isset($key, $cronjob_key) && $cron_status && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('status');
}

if(isset($key, $cronjob_key) && $cron_multi_status && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('multi_status');
}

if(isset($key, $cronjob_key) && $cron_update && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('update');
}

if(isset($key, $cronjob_key) && $cron_refill_order && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('refill_order');
}

if(isset($key, $cronjob_key) && $cron_refill_status && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('refill_status');
}

if(isset($key, $cronjob_key) && $cron_dripfeed && !empty($cronjob_key) && $cronjob_key === $key){
	$cron->cron('dripfeed');
}

if(isset($key, $cronjob_key) && $cron_subscriptions && !empty($cronjob_key) && $cronjob_key === $key){
    $cron->cron('subscriptions');
}


if(isset($key, $cronjob_key) && !empty($cronjob_key) && $cronjob_key !== $key){
    echo "کلید کرون جاب اشتباه است";
}
