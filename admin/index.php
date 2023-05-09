<?php
include dirname(__DIR__) . '/functions/auth.php';
if ($userName != 'admin') Die("Ты не пройдешь!");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include dirname(__DIR__) . "/widgets/admin.php" ?>
Добро пожаловать в Админку!
</body>
</html>