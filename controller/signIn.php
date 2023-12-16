<?php
session_start();
require '../model/Auth.php';

$data = $_POST;

if (!empty($data['password'] && !empty($data['login']))) {
    $password = $data['password'];
    $login = $data['login'];
    $user = new Auth($login, $password);
    $user = $user->createAuth();
} else {
    http_response_code(400);
    echo json_encode(['error' => ['[!]Введены не все данные']]);
}
