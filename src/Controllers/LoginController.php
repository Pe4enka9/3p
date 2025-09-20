<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController extends Controller
{
    public function loginPage(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        return $this->renderer->render($response, 'auth/login.php');
    }
    public function login(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        $user = ORM::for_table("users")->where('login', $login)->find_one();
        if (!$user) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
        if($password===$user['password']){
            $_SESSION['user_id'] = $user['id'];
        }

        return $response->withHeader('Location', '/notes')->withStatus(302);
    }
    public function logout(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        unset($_SESSION['user_id']);
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}