<?php

class DB
{
    protected $db;
    protected $host = 'localhost';
    protected $dbname = 'gobozovbog';
    protected $loginDB = 'gobozovbog';
    protected $passwordDB = 'Goboz2003';

    // Соединение с БД
    public function __construct()
    {

        try {
            $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->loginDB, $this->passwordDB);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => ["Ошибка БД!: " . $e->getMessage()]]);
            die();
        }
    }
}