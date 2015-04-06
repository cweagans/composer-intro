<?php

namespace cweagans\Habitat\Controllers;

use cweagans\Habitat\Thermostat;
use cweagans\Habitat\Weather;

class ThermostatController extends BaseController {

  protected $config;

  public function __construct($twig, $config) {
    parent::__construct($twig);
    $this->config = $config;
    $this->templateVariables['temperatureUpdated'] = FALSE;
  }

  public function thermostatPage() {
    $thermostat = new Thermostat();
    $weather = new Weather($this->config['forecast_api_key'], $this->config['forecast_lat'], $this->config['forecast_lon']);
    $this->templateVariables['temperature'] = $thermostat->getTemperature();
    $this->templateVariables['currentTemperature'] = $weather->getCurrentTemperature();
    $this->templateVariables['currentHumidity'] = $weather->getCurrentHumidity();
    return $this->renderTemplate('thermostat.twig');
  }

  public function setThermostat() {
    $thermostat = new Thermostat();
    $new_temp = $_POST['temperature'];
    $success = $thermostat->setTemperature($new_temp);
    if ($success) {
      $this->templateVariables['temperatureUpdated'] = TRUE;
    }

    return $this->thermostatPage();
  }

}
