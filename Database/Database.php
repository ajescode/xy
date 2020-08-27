<?php

namespace Database;

use PDO;
use PDOException;

class Database
{

    protected $cn;

    public function __construct(string $host, string $dbName, string $dbPort, string $dbUser, string $dbPass)
    {
        $this->connect($host, $dbName, $dbPort, $dbUser, $dbPass);
    }

    protected function connect(string $host, string $dbName, string $dbPort, string $dbUser, string $dbPass)
    {
        try {
            $this->cn = new PDO("mysql:host=$host;database=$dbName;port=$dbPort", $dbUser, $dbPass);
            $this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAllArticles(int $limit, int $start): array
    {
        $stmt = $this->cn->prepare("SELECT articles.id as id, title, image, text, user_id, articles.create_date, articles.modify_date, users.login as author FROM `database`.`articles` LEFT JOIN `database`.`users` ON users.id=articles.user_id LIMIT ?,?");
        $stmt->bindValue(1, $start, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getArticle(int $id)
    {
        $stmt = $this->cn->prepare("SELECT id, title, image, text, user_id, create_date, modify_date FROM `database`.`articles` WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getUser(int $id)
    {
        $stmt = $this->cn->prepare("SELECT id, login, create_date, permission FROM `database`.`users` WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function checkUserPassword(string $login)
    {
        $stmt = $this->cn->prepare("SELECT id, login, password FROM `database`.`users` WHERE login = :login LIMIT 1");
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getCommentsNumber(int $articleId): int
    {
        $stmt = $this->cn->prepare("SELECT COUNT(*) FROM `database`.`comments` WHERE article_id = :id LIMIT 1");
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}