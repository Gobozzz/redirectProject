<?php
session_start();

require("db/DB.php");

class Link extends DB
{


    public function __construct()
    {
        parent::__construct();
    }



    public function createShortLink($longLink) //создает коротку ссылку
    {
        $shortLink = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/link?';
        $sql = 'SELECT `id` FROM `shortLinks` ORDER BY id DESC LIMIT 1';
        try {
            $sth = $this->db->query($sql);
            $rez =  $sth->fetch(PDO::FETCH_ASSOC);
            $shortLink = $shortLink . ($rez['id'] + 1); //готовая уникальная короткая ссылка

            //добавляем ссылку в БД
            $sql = 'INSERT INTO `shortLinks` ( `shortLink`, `longLink`) VALUES (:shortLink, :longLink)';
            try {
                $this->db->beginTransaction();
                $sth = $this->db->prepare($sql);
                $sth->execute(['shortLink' => $shortLink, 'longLink' => $longLink]);
                $idLink = $this->db->lastInsertId();
                $this->db->commit();
                // если пользователь авторизован прикрепим ссылку к нему
                if (isset($_SESSION['token']) && isset($_SESSION['idUser'])) {
                    $sql = "INSERT INTO `user_shortLink` ( `id_user`, `id_short_link`) VALUES ( :idUser, :idLink)";
                    try {
                        $this->db->beginTransaction();
                        $sth = $this->db->prepare($sql);
                        $sth->execute(['idUser' => $_SESSION['idUser'], 'idLink' => $idLink]);
                        $this->db->commit();
                    } catch (\Throwable $e) {
                        $this->db->rollback();
                        echo json_encode(['error' => ["[!]Ошибка связи ссылки с пользователем[3] " . $e->getMessage()]]);
                    }
                }
                http_response_code(200);
                echo json_encode(['succesText' => "Ссылка успешно создана", 'shortLink' => $shortLink]);
            } catch (\Throwable $e) {
                $this->db->rollback();
                http_response_code(400);
                echo json_encode(['error' => ["[!]Ошибка создания ссылки[2] " . $e->getMessage()]]);
            }
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['error' => ["[!]Ошибка получения ссылки[1] " . $e->getMessage()]]);
        }
    }



    public function redirectLink($shortLink) //функция для поиска ссылки для редиректа
    {
        $sql = 'UPDATE `shortLinks` SET `count` = `count` + 1 WHERE `shortLink`=:shortLink';
        try { //увеличиваем количество переходов по ссылке
            $this->db->beginTransaction();
            $sth = $this->db->prepare($sql);
            $sth->execute(['shortLink' => $shortLink]);
            $this->db->commit();
            //получаем длинную ссылку и редиректим туда пользователя
            $countRow = $sth->rowCount();

            if ($countRow == 0) {
                return ['status' => false, 'error' => "Нету такой ссылки"];
            }


            $sql = 'SELECT `longLink` FROM `shortLinks` WHERE `shortLink`=:shortLink ';
            try {
                $sth = $this->db->prepare($sql);
                $sth->execute(['shortLink' => $shortLink]);
                $rez = $sth->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'link' => $rez['longLink']];
            } catch (\Throwable $e) {
                return ['status' => false, "error" => $e->getMessage()];
            }
        } catch (\Throwable $e) {
            $this->db->rollback();
            return ['status' => false, "error" => $e->getMessage()];
        }
    }
}