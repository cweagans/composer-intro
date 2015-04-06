<?php

namespace cweagans\Habitat\Controllers;

use cweagans\Habitat\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BaseController {
  protected $templateVariables = array();
  protected $twig;

  /**
   * Constructor for our controllers. Twig is injected.
   *
   * @param \Twig_Environment $twig
   */
  public function __construct(\Twig_Environment $twig) {
    $this->templateVariables['user']['authenticated'] = User::getInstance()->isAuthenticated();
    $this->twig = $twig;
  }

  /**
   * Render a Twig template.
   *
   * @param $template
   * @return string
   */
  protected function renderTemplate($template) {
    return $this->twig->render($template, $this->templateVariables);
  }

  /**
   * Redirect a user to some other path.
   *
   * @param $path
   */
  protected function redirect($path) {
    return new RedirectResponse($path);
  }
}
