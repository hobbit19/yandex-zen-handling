<?php

namespace lib;

use PDO;

class MysqlDriver
{
    private static $_connection = null;

    private function __construct() {}
    private function __clone () {}
    private function __wakeup () {}

    public static function getConnection()
    {
        if (self::$_connection === null) {
            $dbConfig = Config::get('db');
            self::$_connection = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['database'], $dbConfig['login'], $dbConfig['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
        }

        return self::$_connection;
    }
}