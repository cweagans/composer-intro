<?php

namespace cweagans\Habitat;

class User {

  protected $authenticated = FALSE;

  private static $_instance = null;

  /**
   * Factory method. Creates a new instance of this class, but only if one hasn't already been created.
   *
   * If one HAS already been created, then return the one that was already created.
   */
  public static function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }
    return self::$_instance;
  }

  /**
   * Private constructor prevents somebody from just creating a new user object.
   */
  private function __construct() {
    session_start();
    $this->authenticated = isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : FALSE;
  }

  public function isAuthenticated() {
    return $this->authenticated;
  }

  /**
   * Attempt a user login, and set up the session if it's successful.
   *
   * @param string $username
   * @param string $password
   * @return bool
   */
  public function attemptLogin($username, $password) {
    if ($this->validateCredentials($username, $password)) {
      $this->authenticated = TRUE;
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Log out a user.
   */
  public function logout() {
    session_destroy();
    session_start();
    $this->authenticated = false;
  }

  /**
   * Validate user credentials.
   *
   * @param string $username
   * @param string $password
   * @return bool
   */
  protected function validateCredentials($username, $password) {
    if ($username == 'admin' && $password == 'password') {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * When this object is destroyed, persist any data that we need to track to $_SESSION.
   */
  public function __destruct() {
    $_SESSION['logged_in'] = $this->authenticated;
  }
}
