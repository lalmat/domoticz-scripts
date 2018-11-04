<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include __DIR__."/../domoticz/domoticz.class.php";
include __DIR__."/../forecast/forecast.class.php";
include __DIR__."/newday.class.php";

// Initiate Domoticz Bridge API
$dz = new Domoticz();

// Get forecast script configuration
$forecast_idx = $dz->config('forecast');

// Get Wind data
$reply = json_decode($dz->value($forecast_idx->wind));
$wind  = $reply->result[0];

// Get Weather Data
$reply   = json_decode($dz->value($forecast_idx->weather));
$weather = $reply->result[0];
//print_r($weather);

$msgTemplate = file_get_contents(__DIR__."/message.tpl.html");
$tpl = str_replace("{{prenom}}", "Mathieu", $msgTemplate);
$tpl = str_replace("{{full_date}}", NewDay::getFullDate_FR(), $tpl);
$tpl = str_replace("{{saints}}", NewDay::getSaintMsg_FR(), $tpl);
$tpl = str_replace("{{sunrise}}", $reply->Sunrise, $tpl);
$tpl = str_replace("{{sunset}}", $reply->Sunset, $tpl);
$tpl = str_replace("{{daylength}}", $reply->DayLength, $tpl);
$tpl = str_replace("{{forecast}}", Forecast::get_forecast("fr", $wind->Direction, $weather->Barometer), $tpl);
$tpl = str_replace("{{temperature}}", $weather->Temp, $tpl);
$tpl = str_replace("{{wind}}", round($wind->Speed*3600/1000), $tpl);
$tpl = str_replace("{{wind_orient}}", $wind->DirectionStr, $tpl);

// Send the e-mail
require_once(__DIR__.'/../submodules/PHPMailer/src/PHPMailer.php');
require_once(__DIR__.'/../submodules/PHPMailer/src/Exception.php');
require_once(__DIR__.'/../submodules/PHPMailer/src/SMTP.php');

// Load mail config
$config = json_decode(file_get_contents(__DIR__."/../config/domoticz.config.json"));

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = $config->smtp->host;
$mail->Port = $config->smtp->port;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $config->smtp->user;
$mail->Password = $config->smtp->pass;
$mail->setFrom($config->smtp->usermail, $config->smtp->username);
foreach($config->users as $u)  {
  $mail->addAddress($u->email, $u->firstname." ".$u->lastname);
}
$mail->isHTML(true); 
$mail->Subject = utf8_decode('[La Maison] Une nouvelle journée commence !');
$mail->msgHTML($tpl, __DIR__);
$mail->send();