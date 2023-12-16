<!-- страница регистрации -->
<?php
require('header.php')
?>





<form class="sign" id="signUp">
    <div class="msg"></div>
    <div class="title">Регистрация</div>
    <input type="text" name="name" placeholder="Введите ваше имя">
    <input type="email" placeholder="Введите логин(email)" name="login">
    <input type="password" placeholder="Введите пароль" name="password">
    <button class="submit">Зарегестрироваться</button>
</form>





<?php
require('footer.php');
?>