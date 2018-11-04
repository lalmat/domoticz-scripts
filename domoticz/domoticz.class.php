<?php
class Domoticz {
  private $endpoint = "";
  private $token    = "";
  private $idx      = null;

  function __construct() {
    $config = json_decode(file_get_contents(__DIR__."/../config/domoticz.config.json"));
    $this->endpoint   = $config->domoticz->api;
    $this->token      = $config->domoticz->token;
    $this->scriptsIdx = $config->domoticz->scripts_idx;
  }

  function __destruct() {
  }

  public function config($script) {
    return $this->scriptsIdx->$script;
  }

  public function toggleLight($idx, $value) {
    $idx    = $idx*1;
    $subUrl = "/json.htm?type=command&param=switchlight&idx=$idx&switchcmd=".($value?'On':'Off');
    return $this->api($subUrl);
  }

  public function value($idx) {
    $subUrl = "/json.htm?type=devices&rid=$idx";
    return $this->api($subUrl);
  }

  public function set($idx, $value) {
    $subUrl = "/json.htm?type=command&param=udevice&idx=$idx&nvalue=0&svalue=".urlencode($value);
    return $this->api($subUrl);
  }

  private function api($subUrl) {
    $context = null;
    if ($this->token != "") {
      $opts = array(
        'http'=>array(
          'method'=>"GET",
          'header'=>"Accept: application/json\r\n" .
                    "Content-Type: application/json\r\n".
                    "Authorization: Basic ".$this->token."\r\n"
        ),
        'ssl' => array(
          'verify_peer'   => true,
          'allow_self_signed' => true,
          'verify_peer_name' => false
        )
      );
      $context = stream_context_create($opts);
    }
    return file_get_contents($this->endpoint.$subUrl, false, $context);
  }
}