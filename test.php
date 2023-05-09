<?php

$pass = 123;
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo $hash;


session_start();//
//$_SESSION['login'] = 'admin';
var_dump($_SESSION);

die();

var_dump(password_verify(12354, $hash));

setcookie("login", "", time()-36000, '/');
unset($_COOKIE['login']);
var_dump($_COOKIE);