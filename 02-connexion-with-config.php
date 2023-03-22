<?php

require_once "config.php";

$db = new PDO(DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET,
    DB_USER,
    DB_PWD
);

var_dump($db);

$db = null;