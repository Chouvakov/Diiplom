<?php
$login = filter_var(trim($_POST['login']),
FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['password']),
FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST['email']),
FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']),
FILTER_SANITIZE_STRING);
$mysql = new mysqli('localhost','root','root','register-bg');
if ($login != "" AND $password != "" AND $email != "" AND  $name != ""){
	$resultat = mysqli_query($mysql,"INSERT INTO `users` (`login`,`password`,`email`,`name`) VALUES ('$login','$password','$email','$name')");
$mysql ->close();
header('Location: autorization.html');
}
?>