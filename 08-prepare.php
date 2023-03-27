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
    <title>Requêtes préparées</title>
</head>
<body>
    <h1>Requêtes préparées</h1>
    <h2>On les utilise toujours lors d'entrées utilisateurs dans une requête</h2>
    <p>Prépare une requête SQL à être exécutée par la méthode PDOStatement::execute(). Le modèle de déclaration peut contenir zéro ou plusieurs paramètres nommés (:nom) ou marqueurs (?) pour lesquels les valeurs réelles seront substituées lorsque la requête sera exécutée. L'utilisation à la fois des paramètres nommés ainsi que les marqueurs est impossible dans un modèle de déclaration ; seul l'un ou l'autre style de paramètre. Utilisez ces paramètres pour lier les entrées utilisateurs, ne les incluez pas directement dans la requête.<br><br>

Vous devez inclure un marqueur avec un nom unique pour chaque valeur que vous souhaitez passer dans la requête lorsque vous appelez PDOStatement::execute(). Vous ne pouvez pas utiliser un marqueur avec deux noms identiques dans une requête préparée, à moins que le mode émulation ne soit actif.</p>
<h3>Avec marqueurs : ? et bindParam</h3>
<p>Avec des marqueurs, la lecture se fait de gauche à droite et de bas en haut, on commence à compter à 1</p>
<?php
$debut = "2023-02-12";
$fin = "2023-03-27 14:30";
$sql = "SELECT * FROM `post` WHERE datecreate < ? AND datecreate > ? ;";
// requête préparée
$prepare = $db->prepare($sql);

// attribution des valeurs grâce à bindParam
$prepare->bindParam(1,$fin,PDO::PARAM_STR);
$prepare->bindParam(2,$debut,PDO::PARAM_STR);

$prepare->execute();

// ligne pour utiliser le FETCH_ASSOC sans le mentionnez dans le fetchAll()
$prepare->setFetchMode(PDO::FETCH_ASSOC);

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
echo "<hr>";
$debut = "2023-02-10 10:52";
$fin = "2023-03-27 14:14";

$prepare->execute();

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);


?>
<h3>Avec paramètres nommés : :nom et bindParam</h3>
<p>Avec des paramètres nommés, l'ordre n'a plus d'importance</p>
<?php
$debut = "2023-02-12";
$fin = "2023-03-27 14:30";
$sql = "SELECT * FROM `post` WHERE datecreate < :end AND datecreate > :begin ;";
// requête préparée
$prepare = $db->prepare($sql);

// attribution des valeurs grâce à bindParam
$prepare->bindParam("begin",$debut,PDO::PARAM_STR);
$prepare->bindParam("end",$fin,PDO::PARAM_STR);


$prepare->execute();

// ligne pour utiliser le FETCH_ASSOC sans le mentionnez dans le fetchAll()
$prepare->setFetchMode(PDO::FETCH_ASSOC);

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
echo "<hr>";
$debut = "2023-02-10 10:52";
$fin = "2023-03-27 14:14";

$prepare->execute();

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);


?>
<h3>Différence avec bindValue</h3>
<p>Le bindParam permet de garder la requête préparée en mémoire, mais il faut des variables pour que celà fonctionne, bindParam pas</p>
<?php
$debut = "2023-02-12";
$fin = "2023-03-27 14:30";
$sql = "SELECT * FROM `post` WHERE datecreate < ? AND datecreate > ? ;";
// requête préparée
$prepare = $db->prepare($sql);

// attribution des valeurs grâce à bindParam
$prepare->bindValue(2,$debut,PDO::PARAM_STR);
$prepare->bindValue(1,$fin,PDO::PARAM_STR);

$prepare->execute();

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);

echo "<hr><h3>Cette méthode ne fonctionne pas avec bindValue</h3>";
$debut = "2023-02-10 10:52";
$fin = "2023-03-27 14:14";

$prepare->execute();

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
echo "<hr><h3>Il faut refaire la requête préparée</h3>";
$sql = "SELECT * FROM `post` WHERE datecreate < ? AND datecreate > ? ;";
// requête préparée
$prepare = $db->prepare($sql);

// attribution des valeurs grâce à bindParam
$prepare->bindValue(2,"2023-02-10 10:52",PDO::PARAM_STR);
$prepare->bindValue(1,"2023-03-27 14:14",PDO::PARAM_STR);

$prepare->execute();

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
?>
<h3>Mode raccourci</h3>
<p>Suffit à bloquer les injections SQL, mais ne vérifie pas le type, c'est un équivalent au bindValue</p>
<h4>nommé </h4>
<?php
$sql = "SELECT * FROM `post` WHERE datecreate < :fin AND datecreate > :debut ;";
// requête préparée
$prepare = $db->prepare($sql);
$prepare->execute(['fin'=>"2023-03-27 14:14", 'debut'=>"2023-02-10 10:52"]);

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
?>
<h3>Avec marqueurs : ? et équivalence bindValue</h3>
<pre><code>// requête préparée
$prepare = $db->prepare("SELECT * FROM `post` WHERE datecreate < ? AND datecreate > ? ;");
$prepare->execute(["2023-03-27 14:14","2023-02-10 10:52"]);</code></pre>
<?php
$sql = "SELECT * FROM `post` WHERE datecreate < ? AND datecreate > ? ;";
// requête préparée
$prepare = $db->prepare($sql);
$prepare->execute(["2023-03-27 14:14","2023-02-10 10:52"]);

$getPostByDate = $prepare->fetchAll();

var_dump($getPostByDate);
?>
</body>
</html>