<!DOCTYPE html>
<html lang="ru">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рыболовный форум "Гаечка"</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">

    <style>
        body { font-size: 14px; font-family: Roboto, Arial; }
        .wrapper { display: grid; grid-template-columns: 0.3fr 1fr 0.3fr; }
        h1 { font-size: 30px; padding: 0; margin: 20px 0 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td {background: #eee; border: #aaa 1px solid; padding: 10px; vertical-align: top; }
        table th { background: #eee; }
        a { color: #006696; }
        a:hover { color: #ef1f1f; }
        .messages tbody tr td:first-child { width: 25%; }
        .messages tbody tr td:first-child a { display: inline-block; }
        .messages tbody tr td:first-child span { display: block; margin: 10px 0; }
        .message_form textarea { width: 95%; padding: 3px; height: 200px; outline: none; border: #aaa 1px solid; font-size: 12px; background: #eee; }
        .message_form input[type="text"] { width: 95%; padding: 3px; border: #aaa 1px solid; font-size: 16px; background: #eee; outline: none; }
        .message_form input[type="submit"] { padding: 10px 40px; border: #aaa 1px solid; font-size: 12px; background: #eee; cursor: pointer; }
        .message_form input[type="submit"]:hover { border: #aaa 1px solid; font-size: 12px; background: #bdfdaf; }
        .reply_form { margin-top: 20px; margin-bottom: 300px; }
    </style>
</head>
<body>
<?php
    $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
    $dannie = mysqli_query($mysql, "SELECT * FROM `comments`WHERE topicId = '{$_REQUEST['topicId']}'");
    $mssglist = [];
    if ($dannie->num_rows > 0) {
        while ($title = $dannie->fetch_assoc()) {
            $mssglist[] = $title;
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
    <?php if ($_REQUEST['action'] === 'add_comments' && $_COOKIE['user_id']) {
        $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
        $resultat = mysqli_query($mysql, "INSERT INTO `comments` (`topicId`, `user_id`,`message`,`dateCreate`) VALUES ('{$_POST['topicId']}', '{$_COOKIE['user_id']['id']}','{$_REQUEST['message']}', '".time()."')");
        
        $mysql = new mysqli('localhost', 'root', 'root', 'register-bg');
        $resultat = mysqli_query($mysql,"UPDATE `posts`SET countmessage=countmessage + 1,DateReply='".time()."',replyUser_Id = '{$_COOKIE['user_id']['id']}' WHERE id = '{$_REQUEST['topicId']}'");
        die(header('Location: messanger.php?topicId='.$_REQUEST['topicId']));

    }
    ?>
<div class="wrapper">
    <div class="sidebar_left"></div>
    <div class="content">
        <h1><a href="index.php/">Форум</a>- Название темы</h1>
        <table class="messages">
            <thead>
                <tr>
                    <th>Автор</th>
                    <th>Сообщение</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mssglist as $mssg):?>
                <tr>
                    <td>
                        <a href="#"><?=$userlist[$mssg['user_id']]['name']?></a>
                        <span><?=date('d-m-Y H:i:s',$mssg['datecreate'])?></span>
                        <a href="#">Удалить</a>
                        <a href="messanger.php?action=topicId=<?=$_REQUEST['topicId']?>&mode=edit&mssgId=<?=$mssg['id']?>">Изменить</a>
                    </td>
                    <td>
                     <?php if($_REQUEST['mode']==='edit' && (int)$mssg['id']===(int)$_REQUEST['mssgid']):?>
                        <form class="message_form" action="" method="post">
                            <input type="hidden" name="messageId" value=<?"['$mssg']"?>>
                            <textarea name="message"><?$mssg['message']?></textarea>
                            <input type="submit" name="edit_save" value="Сохранить изменения">
                            <input type="submit" name="edit_cancel" value="Отмена">
                        </form>
                        <?php else:?>
                            <?= $mssg['message']?>
                        <?php endif?>
                </td>
                    
                </tr>
                <?php endforeach?>
                <tr>
                    <td>
                        <a href="#">влад</a>
                        <span>33.33.3333 в 13:00</span>
                        <a href="#">Удалить</a>
                        <a href="#">Изменить</a>
                    </td>
                    <td>
                        
                        <form class="message_form" action="" method="post">
                            <input type="hidden" name="message_id" value="12">
                            <textarea name="message"><?$mssg['message']?></textarea>
                            <input type="submit" name="edit_save" value="Сохранить изменения">
                            <input type="submit" name="edit_cancel" value="Отмена">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="reply_form">
            <thead>
                <tr>
                    <th>Ответить в тему</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form class="message_form" action="messanger.php?action=add_comments" method="post">
                            <input type="hidden" name="topicId" value="<?=$_REQUEST['topicId']?>">
                            <textarea name="message" placeholder="Напишите ответ"></textarea>
                            <input type="submit" name="reply" value="Ответить">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="sidebar_right"></div>
</div>
</body></html>