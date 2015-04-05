<?php

class Util {
  public static function redirect($path) {
    header("Location: " . $path);
    exit();
  }
}
