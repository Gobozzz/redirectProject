<?php
session_start();
include_once('model/User.php');

$auth = isset($_SESSION['token']) ? true : false; //есть ли авторизованный пользователь
if (!$auth && !isset($_SESSION['idUser'])) {
    header('Location: /signIn');
}

$userId = $_SESSION['idUser'];

$user = new User();
$userData = $user->getUserData($userId); //получаю данные пользователя

$user_links = $user->getLinksForUserId($userId); // получаю ссылки пользователя

require('header.php')
?>

<aside>
    <a href="profile"><?php echo $userData['name'] ?></a>
    <a href="/">Добавить ссылку</a>
    <a href="exit">Выход</a>
</aside>

<main>

    <div class="container">
        <h2 class="title">Мои ссылки</h2>
        <table>
            <thead>
                <tr>
                    <th>Короткая ссылка</th>
                    <th>Кол-во переходов по ней</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($user_links as $link) {
                ?>
                    <tr>
                        <td><a href="<? echo $link['shortLink'] ?>"><? echo $link['shortLink'] ?></a></td>
                        <td><? echo $link['count'] ?></td>
                    </tr>
                <?
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require('footer.php');
?>