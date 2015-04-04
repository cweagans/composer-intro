<?php

/**
 * Save the temperature setting.
 *
 * @param string $temperature
 * @return bool Whether or not the save was successful.
 */
function thermostat_save_temperature($temperature) {
  if ($temperature != 'hot' && $temperature != 'cold' && $temperature != 'off') {
    return FALSE;
  }

  file_put_contents('/tmp/temperature.json', json_encode(array('temperature' => $temperature)));

  return TRUE;
}

/**
 * Get the temperature setting.
 *
 * @return string
 */
function thermostat_get_temperature() {
  if (file_exists('/tmp/temperature.json')) {
    $data = file_get_contents('/tmp/temperature.json');
    $data = json_decode($data);
    return $data->temperature;
  }
  else {
    return 'off';
  }
}
