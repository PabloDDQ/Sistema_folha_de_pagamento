<?php
namespace App;

use PDO;

class Conexao
{
    private static $instance;
    public static function getConn()
    {
        if (!isset(self::$instance)) {
            $env = parse_ini_file(__DIR__ . '/../dados_bd.env');
            $host = $env['DB_HOST'];
            $port = $env['DB_PORT'];
            $dbname = $env['DB_NAME'];
            $user = $env['DB_USER'];
            $password = $env['DB_PASS'];

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            self::$instance = new PDO($dsn, $user, $password);

            self::$instance->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
        return self::$instance;
    }
}
