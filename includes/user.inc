<?php

// Start the session whenever this file is included.
session_start();

/**
 * Validate user credentials.
 *
 * @param string $username
 * @param string $password
 * @return bool
 */
function user_validate_credentials($username, $password) {
  if ($username == "admin" && $password == "password") {
    return TRUE;
  }
  return FALSE;
}

/**
 * Starts a session for an authenticated user.
 */
function user_start_session() {
  $_SESSION['logged_in'] = TRUE;
}

/**
 * End a user's session.
 */
function user_destroy_session() {
  $_SESSION = array();
  session_destroy();
  session_start();
}

/**
 * Check to see if a user is logged in.
 */
function user_is_authenticated() {
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE) {
    return TRUE;
  }
  return FALSE;
}
