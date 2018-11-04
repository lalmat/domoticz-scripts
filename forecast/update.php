<?php
include __DIR__."/domoticz.class.php";
include __DIR__."/forecast.class.php";

// Initiate Domoticz Bridge API
$dz = new Domoticz();

// Get script configuration
$idx = $dz->config('forecast');

// Get Wind data
$reply = json_decode($dz->value($idx->wind));
$wind  = $reply->result[0];

// Get Weather Data
$reply   = json_decode($dz->value($idx->weather));
$weather = $reply->result[0];

// Get Forecast
$forecast = Forecast::get_forecast("fr", $wind->Direction, $weather->Barometer);

// Set Forecast in Domoticz
$dz->set($idx->result, $forecast[0]);