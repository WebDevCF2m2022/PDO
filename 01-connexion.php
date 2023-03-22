<?php

/*
 Instanciation de PDO - mot clef new suivit de la classe et des paramètres passés au constructeur (__construct($param)) de la classe PDO. Pour être certain de notre connexion, qui dépend d'une extension externe (donc différente suivant les serveurs) on évitera de laisser des espaces et des retours à la ligne comme dans cet exemple
 On mettra les variables (ou constantes) de connexion dans un fichier protégé séparé
*/

$connect = new PDO("mysql:host=localhost;
                          port=3307;
                          dbname=mvcprojets;
                          charset=utf8;",
                          "root",
                          "");

// en croyant assigner la "valeur" de la variable $connect à $connect2
$connect2 = $connect;

// on se rend compte que ce ne sont que des liens relatifs vers la même connexion
var_dump($connect,$connect2);
echo "<hr>";

// Voici une réelle nouvelle connexion (chiffre 2 pour le var_dump())
$connect3 = new PDO("mysql:host=localhost;
                          port=3307;
                          dbname=mvcprojets;
                          charset=utf8;",
                          "root",
                          "");


var_dump($connect,$connect2,$connect3);
echo "<hr>";

// fermeture de connexion (non obligatoire en MySQL ou MariaDB - portabilité du code)
$connect3 = null;

var_dump($connect,$connect2,$connect3);

//print_r($connect);