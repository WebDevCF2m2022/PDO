<?php
# dependence
require_once "config.php";
# Connexion PDO $db
require_once "04-good-connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query</title>
</head>
<body>
    <h1>Query</h1>
    <p>Le query est une méthode de l'instance de la classe PDO, c'est donc une sorte de "fonction" déja créée</p>
    <p>On va l'utiliser lors d'un SELECT uniquement si on a pas d'entrées utilisateurs</p>
    <h2>Exemple de query</h2>
    <h3>Avec findAll</h3>
    <p>Utilisation de $dbstmt->findAll() lorsqu'on a plusieurs résultats possibles</p>
    <code>
    <pre>$requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");
var_dump($requestAllCategory);</pre></code>
    <p>
    <?php
    $requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");
    // PDOStatement
    var_dump($requestAllCategory);
    // on va transformer le résultat avec la méthode publique (fonction) ->fetchAll, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en tableau indexé contenant les résultats en tableaux associatifs
    $getAllCategory = $requestAllCategory->fetchAll(PDO::FETCH_ASSOC);
    ?>
</p>
<code>
    <pre>$requestAllCategory = $db->query($sql)
        # le fetchAll est utilisé (mysqli => mysqli_fetch_all procédural)
        # Lorsqu'on a la possibilité d'avoir plus d'un résultat
        # PDO::FETCH_ASSOC est l'équivalent mysqli (MYSQLI_ASSOC) pour PDO,
        # c'est une constante (d'où les ::)
$getAllCategory = $requestAllCategory->fetchAll(PDO::FETCH_ASSOC); 
var_dump($getAllCategory);       
    </pre>

    </code>
<p>
    <?php
    // tableau indexé avec des tableaux associatifs
    var_dump($getAllCategory);

    ?>
    </p>
    <h3>Avec find</h3>
    <p>Utilisation de $db_stmt->find() lorsqu'on a un ou 0 résultat possible</p>
    <p>
    <code>
    <pre>$requestOneUserByUsername = $db->query("SELECT `id`, `username`,`usermail`,`userscreen` 
    FROM `user`
    WHERE `username` = 'andrepalmisano'");
var_dump($requestOneUserByUsername);</pre></code>
    <?php
    $requestOneUserByUsername = $db->query("SELECT `id`, `username`,`usermail`,`userscreen` 
    FROM `user`
    WHERE `username` = 'andrepalmisano'");
    var_dump($requestOneUserByUsername);
    ?>
    <code>
    <pre>$getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);
    var_dump($getOneUserByUsername);</pre></code>
    <?php
    // on va transformer le résultat avec la méthode publique (fonction) ->fetch, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en 1 tableau associatif
    $getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);
    var_dump($getOneUserByUsername);
    ?>
    </p>
    <h4>le fetch PDO, sans résultats, renvoie false (null avec mysqli_fetch_assoc)</h4>
</body>
</html>