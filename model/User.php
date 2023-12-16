
<?php

require('db/DB.php');

class User extends DB
{

    private $name;
    private $login;
    private $password;


    public function __construct()
    {
        parent::__construct();
    }

    public function createUser($name, $login, $password) //создание пользователя
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = md5($password);

        $sql = "INSERT INTO `users` (`name`, `login`, `password`) VALUES ( :name, :login, :password)";
        $countUser = $this->isUser($this->login);
        if ($countUser) {
            http_response_code(400);
            echo json_encode(['status' => false, 'error' => ['[!]Пользователь с такой почтой уже зарегестрирован']]);
        } else {
            try {
                $this->db->beginTransaction();
                $sth = $this->db->prepare($sql);
                $sth->execute(['name' => $this->name, 'login' => $this->login, 'password' => $this->password]);
                $this->db->commit();
                $rez =  ['status' => true];
            } catch (\Throwable $e) {
                $this->db->rollback();
                $rez = ['status' => false, 'error' => ['[!]Ошибка Регистрации']];
            }

            if ($rez['status']) {
                http_response_code(200);
                echo json_encode(['succesText' => 'Успешная регистрация, ' . $this->name . "!"]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => $rez['error']]);
            }
        }
    }

    public function getUserData($id) //данные пользователя
    {

        $sql = "SELECT `name`, `login` FROM `users` WHERE `id`=:id";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(['id' => $id]);
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return 'Errrrr' . $e->getMessage();
        }
    }

    public function getLinksForUserId($id) //ссылки пользователя
    {
        $sql = "SELECT s.`shortLink`, s.`count` FROM `user_shortLink` us JOIN `shortLinks` s WHERE us.`id_user` = :idUser AND us.`id_short_link` = s.`id` ";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute(['idUser' => $id]);
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return 'Error' . $e->getMessage();
        }
    }




    private function isUser($login)
    { //есть ли такой user в БД
        $sql = "SELECT count(*) FROM `users` WHERE `login` = :login LIMIT 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['login' => $login]);
            if ($stmt->fetchColumn()) {
                return true;
            }
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

?>