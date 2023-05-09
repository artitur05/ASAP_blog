<?php include_once "./widgets/login.php";

$isAdmin = !empty($_GET['id']) ? (int)$_GET['id'] : 0;

$check = getConnection()->prepare('SELECT users.id, roles.name FROM users
INNER JOIN roles  on users.role_id = roles.id WHERE users.id = :id');
$check->execute(['id'=>$isAdmin]);
$result = $check->fetch();
?>
<a href="./index.php">Главная</a>
<a href="./categories.php">Категории</a>
<a href="./about.php">О нас</a>

<?php if ($result== 'admin'): ?>
    <a href="./admin/index.php">Админка</a>
<?php endif; ?>
<br>