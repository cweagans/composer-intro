<?php

namespace cweagans\Habitat\Controllers;

class PageController extends BaseController {

  public function homePage() {
    return $this->renderTemplate('home.twig');
  }

  public function aboutPage() {
    return $this->renderTemplate('about.twig');
  }
}
