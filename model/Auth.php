<?php
session_start();
require("db/DB.php");

class Auth extends DB
{

    private $login;
    private $password;

    public function __construct($login, $password)
    {
        parent::__construct();
        $this->login = $login;
        $this->password = md5($password);
    }


    // создание аутентификации
    public function createAuth()
    {
        $sql = "SELECT `id` FROM `users` WHERE `login` = :login AND `password`= :password LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['login' => $this->login, 'password' => $this->password]);
            $countRez = $stmt->rowCount();

            if ($countRez) {
                http_response_code(200);

                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $token = $user['id'] . '-' . mt_rand();
                $_SESSION['token'] = $token;
                $_SESSION['idUser'] = $user['id'];
                echo json_encode(['status' => true, 'token' => $token]);
            } else {
                http_response_code(400);
                echo json_encode(['status' => false, 'error' => ['[!]Такого пользователя не существует']]);
            }
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['status' => false, 'error' => ['[!]Ошибка БД' . $e->getMessage()]]);
        }
    }
}
