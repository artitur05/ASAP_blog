<?php
session_start();
include_once dirname(__DIR__) . "/functions/db.php";

if (isset($_POST['login'])) {

    $login = strip_tags($_POST['login']);
    $pass = strip_tags($_POST['pass']);

    if (auth($login, $pass)) {
        //setcookie('login', 'admin', time() + 36000, '/');
        $_SESSION['login'] = $login;
        header('Location: /');
        die();
    } else {
        die("Не правильный логин пароль");
    }
}

function isAdmin() {};

function auth($login, $pass)
{
    $result = getConnection()->prepare("SELECT * FROM users WHERE login = :login");
    $result->execute(['login' => $login]);
    $user = $result->fetch();
    if ($user === false) return false;
//сохранить случайный хеш в юзера и в куку
    if (password_verify($pass, $user['pass'])) return true;
}

$auth = false;
$userName = null;
if (isset($_SESSION['login'])) {
    $auth = true;
    $userName = $_SESSION['login'];
}

if (isset($_GET['logout'])) {
    //  setcookie('login', 'admin', time() - 36000, '/');
    unset($_SESSION['login']);
    header('Location: /');
    die();
}

