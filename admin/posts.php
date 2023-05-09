<?php
include dirname(__DIR__) . "/functions/db.php";
include dirname(__DIR__) . "/functions/upload.php";
include dirname(__DIR__) . '/functions/auth.php';
if ($userName != 'admin') Die("Ты не пройдешь!");


$messages = [
    'del' => 'Пост удален',
    'add' => 'Пост добавлен',
    'edit' => 'Пост изменен',
    'error' => 'Ошибка, нет такого поста',
    'error1' => 'Загрузка php-файлов запрещена!',
    'error2' => 'Размер файла не больше 5 мб',
    'error3' => 'Ошибка загрузки файла',

];
$action = $_GET['action'] ?? '';

$message = !empty($_GET['status']) ? $messages[$_GET['status']] ?? '' : '';

$raw = [
    'id' => 0,
    'title' => '',
    'text' => '',
    'image' => '',
    'category_id' => '',
];
$formAction = "add";
$formText = "Добавить";


//CRUD Edit
if ($action == 'edit') {
    $id = (int)$_GET['id'];
    $result = getConnection()->prepare("SELECT * FROM posts WHERE id = :id");
    $result->execute(['id' => $id]);
    $raw = $result->fetch();

    if (!$raw) {
        header("Location: ?status=error");
        die();
    }

    $formAction = "save";
    $formText = "Изменить";
}

if ($action == 'save') {

    $title = strip_tags($_POST['title']);
    $category_id = strip_tags($_POST['category']);
    $text = strip_tags($_POST['text']);
    $id = (int)$_POST['id'];
    $isDeleteImage = $_POST['isDeleteImage'] ?? null;


    if ($isDeleteImage == "yes") {
        $image = null;
    } else {
        $image = strip_tags($_POST['image']);
    }


    //обработчик загрузки изображения
    if (!empty($_FILES['image']['name'])) {
        $image = upload();
    }

    $result = getConnection()->prepare("UPDATE posts SET title = ?, text = ?, category_id = ?, image = ? WHERE id = ?");
    $result->execute([$title, $text, $category_id, $image, $id]);

    header("Location: ?status=edit");
    die();
}
//CRUD Create
if ($action == 'add') {
    $title = strip_tags($_POST['title']);
    $category_id = strip_tags($_POST['category']);
    $text = strip_tags($_POST['text']);


    $image = '';
    //обработчик загрузки изображения
    if (!empty($_FILES)) {
        $image = upload();
    }


    $result = getConnection()->prepare("INSERT INTO posts (title, text, category_id, image) VALUES (?,?,?,?)");
    $result->execute([$title, $text, $category_id, $image]);

    header("Location: ?status=add");
    die();
}

//CRUD Delete
if ($action == 'delete') {
    $id = (int)$_GET['id'];
    $result = getConnection()->prepare("DELETE FROM posts WHERE id = :id");
    $result->execute(['id' => $id]);
    header("Location: ?status=del");
    die();
}

//CRUD READ
$result = getConnection()->prepare("SELECT id,title FROM posts ORDER BY id DESC");
$result->execute();
$posts = $result->fetchAll();


$resultCategories = getConnection()->prepare("SELECT * FROM categories");
$resultCategories->execute();
$categories = $resultCategories->fetchAll();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include dirname(__DIR__) . "/widgets/admin.php" ?>
<h2>Crud посты</h2>
<h3 style="color: red"><?= $message ?></h3>
<form action="?action=<?= $formAction ?>" method="post" enctype="multipart/form-data">
    Заголовок поста:<br>
    <input type="text" name="title" value="<?= $raw['title'] ?>"><br>
    Категория поста:<br>
    <input hidden type="text" name="id" value="<?= $raw['id'] ?>">
    <input hidden type="text" name="image" value="<?= $raw['image'] ?>">

    <select name="category">
        <?php foreach ($categories as $category): ?>
            <option
                <?php if ($category['id'] == $raw['category_id']): ?>
                    selected
                <?php endif; ?>
                value="<?= $category['id'] ?>">  <?= $category['name'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    Текст поста:<br>
    <textarea name="text" cols="30" rows="2"><?= $raw['text'] ?></textarea><br>

    <?php if (!is_null($raw['image'])): ?>
        <img src="/images/<?= $raw['image'] ?>" alt="картинка" width="200"><br>
        Удалить картинку?
        <input type="checkbox" name="isDeleteImage" value="yes"><br>
    <?php endif; ?>


    Загрузите картинку<br>
    <input type="file" name="image"><br>
    <input type="submit" value="<?= $formText ?>">
</form><br>
<?php foreach ($posts as $post): ?>
    <li><a href="/post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
        <a href="?id=<?= $post['id'] ?>&action=edit"><i class="fa fa-edit"></i></a>
        <a href="?id=<?= $post['id'] ?>&action=delete"><i class="fa fa-trash"></i></a>
    </li>
<?php endforeach; ?>
</body>
</html>
