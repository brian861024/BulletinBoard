<?php
class dbPdo
{
    // 資料庫主機設定
    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpassword = '1111';
    private $dbname = 'db';
    private $pdo;

    // 建構函式
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->dbhost};dbname={$this->dbname};charset=utf8", $this->dbuser, $this->dbpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException("資料庫連接失敗，訊息:{$e->getMessage()}");
        }
    }
}
