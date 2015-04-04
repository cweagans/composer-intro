<?php

/**
 * Redirect a user to a given path.
 *
 * @param string $path
 */
function redirect($path) {
  header("Location: " . $path);
  exit();
}
