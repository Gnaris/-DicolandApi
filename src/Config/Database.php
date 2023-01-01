<?php

namespace App\Config;

use \PDO;

class Database{

    private static string $dms = "mysql";
    private static string $host = "localhost";
    private static string $dbname = "dicoland";
    private static string $username = "root";
    private static string $password = "";

    private static ?PDO $database = null;

    public static function getConnection() : PDO
    {
        if(is_null(self::$database))
        {
            self::$database = new PDO(self::$dms.':host='.self::$host.';dbname='.self::$dbname, self::$username, self::$password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        }
        return self::$database;
    }
}

?>