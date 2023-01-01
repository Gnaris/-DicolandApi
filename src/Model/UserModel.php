<?php

namespace App\Model;

class UserModel extends \App\Config\Database{

    private string $table = "membre";

    public function getUsersByID(array $ids) : array
    {
        $req = 'SELECT * FROM '. $this->table . ' WHERE id_membre IN (' . \implode(",", array_fill(0, count($ids), "?")) . ')';
        $stmt = self::getConnection()->prepare($req);
        foreach($ids as $key => $value) $stmt->bindValue($key + 1, $value);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "\App\Entity\User");
        return $data;
    }

    public function deleteUsersByID(array $ids) : bool
    {
        $req = 'DELETE FROM '. $this->table . ' WHERE id_membre IN (' . \implode(",", array_fill(0, count($ids), "?")) . ')';
        $stmt = self::getConnection()->prepare($req);
        foreach($ids as $key => $value) $stmt->bindValue($key + 1, $value);
        return $stmt->execute();
    }

    public function loginUser(string $login, string $password) : array
    {
        $req = 'SELECT id_membre FROM membre WHERE login = ? AND password = ?';
        $stmt = self::getConnection()->prepare($req);
        $stmt->bindValue(1, $login);
        $stmt->bindValue(2, $password);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function registerUser(array $data)
    {
        $req = 'INSERT INTO ' . $this->table . ' VALUES (' . \implode(",", array_fill(0, count($data), "?")) . ')';
        $stmt = self::getConnection()->prepare($req);
        foreach(array_values($data) as $key => $value) $stmt->bindValue($key + 1, $value);
        return $stmt->execute();
    }

    public function getColumnsName() : array
    {
        $req = 'DESCRIBE ' . $this->table;
        $stmt = self::getConnection()->prepare($req);
        $stmt->execute();
        $data_value = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $data;
        foreach($data_value as $value)
        {
            $data[$value] = null;
        }
        return $data;
    }

    public function isExistingAccount(string $mail) : bool
    {
        $req = 'SELECT EXISTS(SELECT email FROM ' . $this->table . ' WHERE email = :email) as isExistingAccount';
        $stmt = self::getConnection()->prepare($req);
        $stmt->execute(["email" => $mail]);
        return $stmt->fetch()["isExistingAccount"];
    }
}

?>