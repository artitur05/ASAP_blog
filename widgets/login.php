<?php if ($auth): ?>
    Привет <?= $userName ?>! <a href="/?logout">Выход</a>
<?php else: ?>
    <form method="post">
        <input type="text" name="login" placeholder="Введите логин">
        <input type="password" name="pass" placeholder="Введите пароль">
        Сохранить пароль? <input type="checkbox" name="save">
        <input type="submit" value="Войти">
    </form>
<?php endif; ?>
<br>