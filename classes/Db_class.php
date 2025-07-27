<?php

class Db {
    private $host = 'localhost';
    private $user = 'u211176085_bbank';
    private $password = 'A5>sL1x^/1';
    private $db_name = 'u211176085_bloodbankdb';

    protected function con() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}