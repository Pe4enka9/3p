<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NoteController extends Controller
{
    public function index(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        $notes = ORM::for_table('notes')->where('user_id', $_SESSION['user_id'])->find_many();
        return $this->renderer->render($response, 'notes/index.php', ['notes' => $notes]);
    }

    public function create(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        return $this->renderer->render($response, 'notes/create.php');
    }

    public function store(
        RequestInterface $request,
        ResponseInterface $response,
    )
    {
        $name = $request->getParsedBody()['name'];
        $text = $request->getParsedBody()['text'];
        ORM::for_table('notes')->create([
            'name' => $name,
            'text' => $text,
            'user_id' => $_SESSION['user_id'],
        ])->save();
        return $response->withHeader('Location', '/notes')->withStatus(302);
    }
    public function edit(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    )
    {
        $id = $args['id'];
        $note = ORM::for_table('notes')->find_one($id);
        return $this->renderer->render($response, 'notes/edit.php', ['note' => $note]);

    }
    public function update(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    )
    {
        $id = $args['id'];
        $name = $request->getParsedBody()['name'];
        $text = $request->getParsedBody()['text'];
        ORM::for_table('notes')->find_one($id)->set([
            'name' => $name,
            'text' => $text,
        ])->save();
        return $response->withHeader('Location', '/notes')->withStatus(302);
    }
    public function delete(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    )
    {
        $id = $args['id'];
        ORM::for_table('notes')->find_one($id)->delete();
        return $response->withHeader('Location', '/notes')->withStatus(302);
    }
}