<?php

namespace cweagans\Habitat\Controllers;

use cweagans\Habitat\User;

class UserController extends BaseController {

  public function loginPage() {
    return $this->renderTemplate('login.twig');
  }

  public function loginSubmit() {
    $user = User::getInstance();

    $valid = $user->attemptLogin($_POST['username'], $_POST['password']);
    if ($valid) {
      return $this->redirect("/admin/thermostat");
    }
    else {
      $this->templateVariables['loginError'] = TRUE;
    }

    return $this->renderTemplate('login.twig');
  }

  public function logout() {
    User::getInstance()->logout();
    return $this->redirect('/');
  }
}
