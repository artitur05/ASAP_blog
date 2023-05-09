<?php
function upload()
{

//Проверка на размер файла
    if ($_FILES["image"]["size"] > 1024 * 5 * 1024) {
        header("Location: ?status=error2");
        die();

    }

//Проверка расширения файла
    $blacklist = ["gdf.jpg.php", ".phtml", ".php3", ".php4"];
    foreach ($blacklist as $item) {
        if (preg_match("/$item\$/i", $_FILES['image']['name'])) {//filen.phpame.php
            header("Location: ?status=error1");
            exit;
        }
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/images/' . $_FILES['image']['name'])) {
        header("Location: ?status=error3");
        die();
    }


    return $_FILES['image']['name'];

}