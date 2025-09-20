<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href="/logout">Выйти</a>
<h1>Заметки</h1>
<a href="/notes/create">Добавить</a>
    <table>
        <tr>
            <td>Время</td>
            <td>Название</td>
            <td>Содержание</td>
        </tr>
        <?php foreach ($notes as $note): ?>
        <tr>
            <td><?=$note['time']?></td>
            <td><?=$note['name']?></td>
            <td><?=$note['text']?></td>
            <td><a href="/notes/<?=$note['id']?>/edit">Редактировать</a></td>
            <td><a href="/notes/<?=$note['id']?>/delete">Удалить</a></td>
        </tr>
        <?php endforeach;?>
    </table>
</body>
</html>