<?php

namespace Src\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController extends Controller
{
  public function index(RequestInterface $request, ResponseInterface $response){
      return $this->renderer->render($response, 'index.php');
  }
}