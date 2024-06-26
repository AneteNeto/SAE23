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
        $SERVEUR = "mysql_serv";
        $LOGIN = "adbneto";
        $PASSW = "adbneto-rt2023";
        $BD = "adbneto_05";

        try {
            if (empty(self::$instance)) {
               /* self::$instance = new PDO(
                    "mysql:host=" .CONF_DB_SERVER .";dbname=" . CONF_DB_NAME . ";charset=utf8mb4",
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    CONF_DB_OPTIONS
                );*/

                 self::$instance = new PDO(
                    "mysql:host=".$SERVEUR.";dbname=".$BD.";charset=utf8mb4",
                    $LOGIN,
                    $PASSW,
                    [
                       \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
                    ]
                );
            }
        } catch (\PDOException $exception) {
            die("Connection failed: " . $exception->getMessage());
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
