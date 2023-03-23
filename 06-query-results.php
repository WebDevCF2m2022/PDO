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
    <title>Query and results</title>
</head>
<body>
    <h1>Query and results</h1>
    <p>Il y a 2 manières d'afficher les résultats d'une requêtes SELECT en PHP</p>
    <h2>Exemple de while sur plusieurs résultats possibles</h2>
    <h3>Avec find et while</h3>
    <p>Utilisation de $dbstmt->find() et while lorsqu'on a plusieurs résultats possibles, reste une pratique courante mais devient une mauvaise pratique en MVC </p>
    <code>
    <pre>   $requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");
    while($item = $requestAllCategory->fetch(PDO::FETCH_ASSOC)){
        echo "<b>ID:</b> $item[id] - <b>Title: {$item['title']}</b> - <b>Content</b> {$item['content']}";
    }
    $requestAllCategory->closeCursor(); // on ferme le curseur des résultats, inutile pour
mysql mais nécessaire pour la portabilité du code
    </pre></code>

    <?php
    $requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");

    while($item = $requestAllCategory->fetch(PDO::FETCH_ASSOC)){
        echo "<p><b>ID:</b> $item[id] - <b>Title: {$item['title']}</b> - <b>Content</b> {$item['content']} </p>";
    }
    $requestAllCategory->closeCursor(); // on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code
    ?>

<h2>Exemple de foreach sur plusieurs résultats possibles</h2>
    <h3>Avec findAll et foreach</h3>
    <p>Utilisation de $dbstmt->findAll() et foreach lorsqu'on a plusieurs résultats possibles, bonne pratique en MVC </p>
    <p>Ceci fonctionne avec PDO::FETCH_ASSOC, mais ici on va le voir avec PDO::FETCH_OBJ</p>
    <code>
    <pre>   $requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");

    $getAllCategory = $requestAllCategory->fetchAll(PDO::FETCH_OBJ);

    $requestAllCategory->closeCursor(); // on ferme le curseur des résultats, inutile pour
mysql mais nécessaire pour la portabilité du code

    foreach($getAllCategory AS $item){
        echo "<b>ID:</b> $item->id - <b>Title: $item->title</b> - <b>Content</b> $item->content";
    }
    </pre></code>

    <?php
    $requestAllCategory = $db->query("SELECT * FROM `category` ORDER BY `title` ASC;");

    $getAllCategory = $requestAllCategory->fetchAll(PDO::FETCH_OBJ);

    $requestAllCategory->closeCursor(); // on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code

    foreach($getAllCategory AS $item){
        echo "<p><b>ID:</b> $item->id - <b>Title: $item->title</b> - <b>Content</b> $item->content </p>";
    }
    ?>


    <h3>Avec find</h3>
    <p>Utilisation de $db_stmt->find() lorsqu'on a un ou 0 résultat possible</p>
    <p>On doit utiliser $db_stmt->rowCount() pour vérifier si on a 1 résultat (mysqli_num_rows() en mysqli procédural)</p>
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
    <h4>Avec résultat</h4>
    <code>
    <pre>// si on a un résultat
if ($requestOneUserByUsername->rowCount()===1) {

    // on va transformer le résultat avec la méthode publique (fonction) ->fetch, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en 1 tableau associatif
    $getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);
    
    // affichage de l'utilisateur
    echo "<b>ID:</b> $getOneUserByUsername[id] - <b>Username: $getOneUserByUsername[username]</b> - <b>Usermail:</b> {$getOneUserByUsername['usermail']} - <b>Userscreen:</b> {$getOneUserByUsername['userscreen']}"";

}else{

    echo "Pas d'utilisateur ayant ce username";
}

$requestOneUserByUsername->closeCursor(); // on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code
</pre></code>
<h4>Avec résultat</h4>
    <?php
// si on a un résultat
if ($requestOneUserByUsername->rowCount()===1) {
    // on va transformer le résultat avec la méthode publique (fonction) ->fetch, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en 1 tableau associatif
    $getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);
    // affichage de l'utilisateur
    echo "<p><b>ID:</b> $getOneUserByUsername[id] - <b>Username: $getOneUserByUsername[username]</b> - <b>Usermail:</b> {$getOneUserByUsername['usermail']} - <b>Userscreen:</b> {$getOneUserByUsername['userscreen']} </p>";
}else{
    echo "<p>Pas d'utilisateur ayant ce username</p>";
}

// on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code
$requestOneUserByUsername->closeCursor(); 
    ?>
    </p>
    <h4>Sans Résultat</h4>
    <code>
    <pre>$requestOneUserByUsername = $db->query("SELECT `id`, `username`,`usermail`,`userscreen` 
    FROM `user`
    WHERE `username` = 'andrepalmisano2'");

    // si on a un résultat
    if ($requestOneUserByUsername->rowCount()===1) {

        // on va transformer le résultat avec la méthode publique (fonction) ->fetch, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en 1 tableau associatif
        $getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);

        // affichage de l'utilisateur
        echo "<b>ID:</b> $getOneUserByUsername[id] - <b>Username: $getOneUserByUsername[username]</b> - <b>Usermail:</b> {$getOneUserByUsername['usermail']} - <b>Userscreen:</b> {$getOneUserByUsername['userscreen']}";

    }else{

        echo "Pas d'utilisateur ayant ce username";
    }

    // on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code
    $requestOneUserByUsername->closeCursor(); 
    </pre>
    </code>
    <?php
    $requestOneUserByUsername = $db->query("SELECT `id`, `username`,`usermail`,`userscreen` 
    FROM `user`
    WHERE `username` = 'andrepalmisano2'");
    // si on a un résultat
    if ($requestOneUserByUsername->rowCount()===1) {
        // on va transformer le résultat avec la méthode publique (fonction) ->fetch, avec la constante PDO::FETCH_ASSOC nous demandons de transformer les données en 1 tableau associatif
        $getOneUserByUsername = $requestOneUserByUsername->fetch(PDO::FETCH_ASSOC);
        // affichage de l'utilisateur
        echo "<p><b>ID:</b> $getOneUserByUsername[id] - <b>Username: $getOneUserByUsername[username]</b> - <b>Usermail:</b> {$getOneUserByUsername['usermail']} - <b>Userscreen:</b> {$getOneUserByUsername['userscreen']} </p>";
    }else{
        echo "<p>Pas d'utilisateur ayant ce username</p>";
    }
    // on ferme le curseur des résultats, inutile pour mysql mais nécessaire pour la portabilité du code
    $requestOneUserByUsername->closeCursor(); 
    ?>
</body>
</html>