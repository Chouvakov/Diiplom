<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рыболовный форум "Гаечка"</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <div class="header">
        <div class="header-section">
            <div class="header-item logo">
                Гаечка
            </div>
            <div class="header-item button"><a href="index.php">
                    Главная</a></div>
            <div class="header-item button"><a href="rules.html">
                    Правила</a></div>
        </div>
        <div class="header-section">
            <div class="header-item button">
                <? print_r($_COOKIE['cookiez']); ?>
            </div>
            <div class="header-item button"><a href="scripts.php">
                    Выход</a></div>
        </div>
    </div>
    <?php
    if ($_REQUEST['action'] === 'add_topic' && $_COOKIE['user_id']) {
        $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
        $resultat = mysqli_query($mysql, "INSERT INTO `posts` (`name`,`countmessage`,`user_id`,`datecreate`)
         VALUES ('{$_REQUEST['topic']}','1','{$_COOKIE['user_id']}'," . time() . ")");
    //    
    //
    $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
     $resultat = mysqli_query($mysql, "INSERT INTO `comments` (`topicId`, `user_id`,`message`,`dateCreate`)
      VALUES ('{$_POST['topicId']}', '{$_COOKIE['user_id']}','{$_POST['message']}', '".time()."')");
$topicId = $mysql->insert_id;
die(header('Location: messanger.php?topicId='.$topicId));
}
    $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
    $dannie = mysqli_query($mysql, "SELECT * FROM `posts`");
    $postlist = [];
    if ($dannie->num_rows > 0) {
        while ($title = $dannie->fetch_assoc()) {
            $postlist[] = $title;
        }
    }
    $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
    $dannie = mysqli_query($mysql, "SELECT * FROM `users`");
    $userlist = [];
    if ($dannie->num_rows > 0) {
        while ($title = $dannie->fetch_assoc()) {
            $userlist[$title['id']] = $title;
        }
    }
    ?>
    <table border="3" class="tabler">
        <tr>
            <th>Название темы</th>
            <th>Кол.Сообщений</th>
            <th>Автор</th>
            <th>Дата создания</th>
            <th>Последний ответ</th>
            <th>Дата ответа</th>
        </tr>
        <?php foreach ($postlist as $topic): ?>
            <tr>
                <td><a href="messanger.php?action=topicId&topicId=<?=$topic['id']?>"> <?= $topic['name'] ?> </a></td>
                <td><a href="#">
                        <?= $topic['countmessage'] ?>
                    </a></td>
                <td><a href="#">
                        <?= $userlist[$topic['user_id']]['name'] ?>
                    </a></td>
                <td><a href="#"><?= date('d-m-Y H:i:s', $topic['datecreate']) ?></a></td>
                <td><a href="#">
                        <?= $userlist[$topic['replyUser_Id']]['name'] ?>
                    </a></td>
                <td><a href="#"><?= $topic['DateReply'] ? date('d-m-Y H:i:s', $topic['DateReply']):'' ?></a></td>
            </tr>
        <?php endforeach ?>
    </table>
    <?php if($_COOKIE['user_id']):?>
    <form class="temswiewer" action="profile.php?action=add_topic" method="post">
        <input type="text" class="form-control" name="topic" id="topic" placeholder="Название темы"><br>
        <textarea name="message" id="message" cols="50" rows="5" placeholder="Напишите сообщение"></textarea>
        <input type="submit" name="create" value="Cоздать">

    </form>
    <?php endif?>
    <footer id="downline">
        <div class="words"><a href="contaks.html">Контакты </a></div>
        <h2 id="itc">Рыболовный форум Гаечка</h3>
    </footer>
</body>