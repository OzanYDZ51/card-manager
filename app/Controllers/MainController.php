<?php
namespace App\Controllers;

class MainController extends CoreController {
  public function home() {
    $this->show('main/home', []);
  }

  public function page404() {
    header("HTTP/1.0 404 Not Found");
    $this->show('main/page404');
  }
}