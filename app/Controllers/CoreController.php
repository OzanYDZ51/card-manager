<?php

namespace App\Controllers;
use League\Plates\Engine as Plates;
use App\Application;
use App\Utils\User;

abstract class CoreController {
  protected $templateEngine;

  public function __construct(Application $application) {
    $config = $application->getConfig();

    $this->router = $application->getRouter();

    $this->templateEngine = new Plates(__DIR__ .'/../Views');

    $this->templateEngine->addData(
        [
            'router' => $this->router,
            'basePath' => $config['BASE_PATH'],
            'connectedUser' => User::getConnectedUser(),
            'isConnected' => User::isConnected(),
        ]
    );
  }

  public function show($templateName, $dataToView=[]){
    echo $this->templateEngine->render($templateName, $dataToView);
  }

  public function forbidden() {
    header("HTTP/1.0 403 Forbidden");
    $this->show('main/forbidden');
  }

  public static function sendJson($data){
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }
  
}