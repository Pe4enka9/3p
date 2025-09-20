<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RegisterController extends Controller
{
    public function registerPage(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        return $this->renderer->render($response, 'auth/register.php');
    }
    public function register(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        ORM::forTable('users')->create([
            'login' => $login,
            'password' => $password,
        ])->save();
        return $response->withStatus(302)->withHeader('Location', '/register');
    }
}