<?php
$login = filter_var(trim($_POST['login']),
FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['password']),
FILTER_SANITIZE_STRING);
$mysql = new mysqli('localhost','root','root','register-bg');
if ($login != "" AND $password != ""){
	$resultat = mysqli_query($mysql,"SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    $resultat = mysqli_fetch_assoc($resultat);
    $logus = $resultat["name"];
    $user_id = $resultat["id"];
    setcookie('cookiez',$logus, time() + 3600);
    setcookie('user_id', $user_id, time() + 3600 );
$mysql ->close();
header('Location: profile.php');
}
if($_REQUEST['action'] === 'auth'){
    $mysql = new mysqli('localhost','root','root','register-bg');
        $resultat = mysqli_query($mysql,"SELECT * FROM `users` WHERE `login` = '{$_REQUEST['login']}' AND `password`= '$password'");
        $user = [];
        if($row = $resultat->fetch_assoc()){
            $user = $row;
            $_SESSION['login'] = $user['login'];
            $_SESSION['password'] = $user['password'];
        }
    } 
?>
