<?php
session_start();
require '../model/User.php';

$data = $_POST;

if (!empty($data['name']) && !empty($data['password'] && !empty($data['login']))) {
    $name = $data['name'];
    $password = $data['password'];
    $login = $data['login'];
    $user = new User();
    $user = $user->createUser($name, $login, $password);
} else {
    http_response_code(400);
    echo json_encode(['error' => ['[!]Введены не все данные']]);
}
