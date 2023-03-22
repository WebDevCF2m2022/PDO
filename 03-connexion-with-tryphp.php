<?php

require_once "config.php";

try {
    $db = new PDO(
        DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET,
        DB_USER,
        DB_PWD
    );
// possible mais à éviter pour la portabilité    
// }catch(PDOException $e){
}catch(Exception $e){
    die($e->getMessage());
}

var_dump($db);

$db = null;