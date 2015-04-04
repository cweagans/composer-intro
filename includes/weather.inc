<?php

/**
 * Load data from
 */
function weather_get_forecast_data() {
  include __DIR__ . '/config.inc';

  // GPS coordinates for 404 S 8th Street.
  $lat = '43.6130304';
  $lon = '-116.2054669';

  // Build the API call URL.
  $url = "https://api.forecast.io/forecast/{$config['forecast_api_key']}/{$lat},{$lon}";

  // Get data from the API. This is cached to disk for an hour.
  if (!file_exists('/tmp/weather_data.json') || filemtime('/tmp/weather_data.json') < (time() - 3600)) {
    $response = file_get_contents($url);
    file_put_contents('/tmp/weather_data.json', $response);
  }
  else {
    $response = file_get_contents('/tmp/weather_data.json');
  }

  // Decode the JSON.
  $response = json_decode($response, TRUE);

  return $response;
}

/**
 * Get the current temperature.
 */
function weather_get_current_temperature() {
  $response = weather_get_forecast_data();
  return round($response['currently']['temperature'], 2);
}

/**
 * Get the current humidity.
 */
function weather_get_current_humidity() {
  $response = weather_get_forecast_data();
  return round($response['currently']['humidity'] * 100, 2);
}
