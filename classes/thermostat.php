<?php

class Thermostat {

  protected $data_file = '/tmp/temperature.json';

  /**
   * Save the temperature setting.
   *
   * @param string $temperature
   * @return bool Whether or not the save was successful.
   */
  public function setTemperature($temperature) {
    if ($temperature != 'hot' && $temperature != 'cold' && $temperature != 'off') {
      return FALSE;
    }

    file_put_contents($this->data_file, json_encode(array('temperature' => $temperature)));

    return TRUE;
  }

  /**
   * Get the temperature setting.
   *
   * @return string
   */
  public function getTemperature() {
    if (file_exists($this->data_file)) {
      $data = file_get_contents($this->data_file);
      $data = json_decode($data);
      return $data->temperature;
    }
    else {
      return 'off';
    }
  }
}
