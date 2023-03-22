<?php

require_once "config.php";

try {
    $db = new PDO(
        DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET,
        DB_USER,
        DB_PWD
    );
    // sur certains serveurs, l'affichage d'erreur est désactivé par défaut pour le driver (extension) PDO, ici on va choisir l'activation si on est en mode dev ou test, mais pas en prod (production voir config.php)
    if(ENV=="dev"||ENV=="test"){
        // activation de l'affichage des erreurs
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

}catch(Exception $e){
    die($e->getMessage());

}
