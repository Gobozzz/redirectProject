<?php
session_start();
$auth = isset($_SESSION['token']) ? true : false;

?>

<?php
require('header.php')
?>

<aside>
    <?php
    if (!$auth) {
    ?>
        <a href="signIn">Войти</a>
        <a href="signUp">Зарегестрироваться</a>
    <?php
    } else {
    ?>
        <a href="profile">Мой аккаунт</a>
        <a href="exit">Выход</a>
    <?php
    }
    ?>
    <a href="/">Добавить ссылку</a>
</aside>

<main>
    <div class="container">
        <h1 class="title">Чтобы укоротить ссылку введите ее в поле ниже и нажмите на кнопку укоротить</h1>
        <div class="msg"></div>
        <form id="addLink">
            <input type="text" placeholder="Введите ссылку" name="longLink">
            <button class="submit">Сгенерировать</button>
            <button class="submit" type="reset">Очистить</button>
        </form>

        <div class="link"></div>

    </div>
</main>

<?php
require('footer.php');
?>