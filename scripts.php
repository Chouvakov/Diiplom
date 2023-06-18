<?php
    function deleteCookie($cookie)
    {
        if (isset($_COOKIE[$cookie])) {
             unset($_COOKIE[$cookie]);
             setcookie($cookie, '', -3600, '/');
        }
    }
    deleteCookie('cookiez');
    deleteCookie ('user_id');
    header("location: index.php");
 ?>