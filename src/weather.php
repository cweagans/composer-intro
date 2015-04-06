<?php

namespace cweagans\Habitat;

class Weather {
  protected $latitude;
  protected $longitude;
  protected $apiKey;
  protected $weatherDataCacheFile = '/tmp/weather_data.json';
  protected $cacheLifetime = 3600;
  protected $weatherData;

  public function __construct($apiKey, $latitude, $longitude) {
    $this->apiKey = $apiKey;
    $this->latitude = $latitude;
    $this->longitude = $longitude;
    $this->weatherData = $this->loadWeatherData();
  }

  /**
   * Load data from Forecast.io.
   */
  protected function loadWeatherData() {
    // Build the API call URL.
    $url = "https://api.forecast.io/forecast/{$this->apiKey}/{$this->latitude},{$this->longitude}";

    // Get data from the API or the cached version on disk.
    if (!file_exists($this->weatherDataCacheFile) || filemtime($this->weatherDataCacheFile) < (time() - $this->cacheLifetime)) {
      $response = file_get_contents($url);
      file_put_contents($this->weatherDataCacheFile, $response);
    }
    else {
      $response = file_get_contents($this->weatherDataCacheFile);
    }

    // Decode the JSON into a multidimensional array.
    $response = json_decode($response, TRUE);

    return $response;
  }

  /**
   * Get the current temperature.
   */
  function getCurrentTemperature() {
    return round($this->weatherData['currently']['temperature'], 2);
  }

  /**
   * Get the current humidity.
   */
  function getCurrentHumidity() {
    return round($this->weatherData['currently']['humidity'] * 100, 2);
  }

}
