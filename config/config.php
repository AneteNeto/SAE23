<?php

    /**
     * Open weather map
     */
    const CONF_API_KEY = "bc6c4dbdd8355327830016c12370d05e";
    const CONF_API_URL= "http://api.openweathermap.org/data/2.5/weather";

    /** 
     * DATABASE
     */
    const CONF_DB_SERVER="mysql_serv";
    const CONF_DB_USER="adbneto";
    const CONF_DB_PASS="adbneto-rt2023"; 
    const CONF_DB_NAME="adbneto_05";

    const CONF_DB_OPTIONS = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ];
?>