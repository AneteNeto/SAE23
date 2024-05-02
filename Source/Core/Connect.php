<?php

/**
 * Class Connect
 */
//require "../config/config.php";
class Connect
{
    /**
     * @var
     */ 
    private static $instance=null;
    /**
     * @return PDO
     */
    public static function getInstance()
    {

        try {
            if (empty(self::$instance)) {
               /* self::$instance = new PDO(
                    "mysql:host=" .CONF_DB_SERVER .";dbname=" . CONF_DB_NAME . ";charset=utf8mb4",
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    CONF_DB_OPTIONS
                );*/

                 self::$instance = new PDO(
                    "mysql:host=localhost;dbname=sae;charset=utf8mb4",
                    "etena",
                    "cookie2017",
                    [
                       \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
                    ]
                );
            }
        } catch (\PDOException $exception) {
            die("Connection failed: " . $e->getMessage());
        }

        return self::$instance;
    }
    /**
     * Connect constructor.
     */
    private function __construct()
    {
    }

    /**
     * Connect constructor.
     */
    private function __clone()
    {
    }
}