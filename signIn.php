<!-- страница авторизации -->
<?php
require('header.php')
?>



<form class="sign" id="signIn">
    <div class="msg"></div>
    <div class="title">Авторизация</div>
    <input type="email" placeholder="Введите логин(email)" name="login">
    <input type="password" placeholder="Введите пароль" name="password">
    <button class="submit">Войти</button>
</form>





<?php
require('footer.php');
?>