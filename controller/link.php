<?php
session_start();
$auth = isset($_SESSION['token']) ? true : false; //есть ли авторизованный пользователь
$userId = $_SESSION['idUser'] ? $_SESSION['idUser'] : false; //есть ли id
require '../model/Link.php';


if (empty($_POST['longLink'])) {
    http_response_code(400);
    echo json_encode(['error' => ["[!]Введите ссылку"]]);
} else {
    $link = new Link();
    $longLink = $_POST['longLink'];
    $link->createShortLink($longLink);
}
