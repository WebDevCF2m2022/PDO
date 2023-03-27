<?php
# dependence
require_once "config.php";
# Connexion PDO $db
require_once "04-good-connection.php";
# fonction qui choisit un nombre de caractères entre int et int, entre a et z + 6 espaces
function randomCaracteres(int $min, int $max): string{
    $caracteres = range('a','z');
    for($i=0;$i<=5;$i++) : $caracteres[]=" "; endfor;
    $sortie = "";
    $random = mt_rand($min,$max);
    for($i=0;$i<$random;$i++){
        $sortie .= $caracteres[array_rand($caracteres)];
    }
    return $sortie;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exec</title>
</head>
<body>
    <h1>Exec</h1>
    <p>Lorsqu'on a pas besoin de récupérer des données avec un SELECT, on utilise $db->exec('sql')</p>
    <p>Valide pour les INSERT, UPDATE, DELETE, mais également des fonctions SQL de gestion de tables ou de DB comme DROP, CREATE, etc...</p>
    <p>Son principal avantage est qu'il nous renvoie le nombre de lignes affactées par notre requête</p>
    <h2>INSERT</h2>
    <?php
    // début requête SQL
    $sql = "INSERT INTO `post` (`title`,`content`,`user_id`) VALUES ";
    // nombre d'insertion
    $nbInsert = mt_rand(1,5);

    // tant q'on doit insérer un article
    for($i=0;$i<$nbInsert;$i++){
        $title = randomCaracteres(5,15);
        $content = randomCaracteres(50,150);
        $sql .= "('$title','$content',1),";
    } 

    // on retire la virgule en trop
    echo $sqlValide = substr($sql,0,-1);
    
    $nombreEntree = $db->exec($sqlValide);

    echo "<h2>Il y a eu $nombreEntree dans la table Post</h2>";
    ?>
</body>
</html>