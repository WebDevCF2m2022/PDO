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
    <h1>Les Transactions</h1>
    <p>Si vous n'avez jamais utilisé les transactions, elles offrent 4 fonctionnalités majeures :
Atomicité, Consistance, Isolation et Durabilité (ACID).</p><p>
En d'autres termes, n'importe quel travail mené à bien dans une transaction, même s'il est
effectué par étapes, est garanti d'être appliqué à la base de données sans risque, et sans
interférence pour les autres connexions, quand il est validé.</p><p>
Le travail des transactions peut également être automatiquement annulé à votre demande
(en supposant que vous n'avez encore rien validé), ce qui rend la gestion des erreurs bien
plus simple dans vos scripts.
</p>
    <h2>Ne fonctionne qu'avec les moteurs acceptant les transactions (InnoDB), pas MyISAM !</h2>
    <h3>$connexion->beginTransaction();</h3>

    <h4>Echec de transaction car il y a une erreur !</h4>


    <?php
    // arrêt de l'auto-commit
    $db->beginTransaction();

    $query = $db->query("SELECT * FROM category");

    $sql1 = "INSERT INTO post (title,content,user_id) VALUES ('".randomCaracteres(10,30)."','".randomCaracteres(150,300)."',1)";
    echo $request1 = $db->exec("$sql1");

    $sql2 = "INSERT INTO post (title,content,user_id) VALUES ('".randomCaracteres(10,30)."','".randomCaracteres(150,300)."',2)";
    echo $request2 = $db->exec("$sql2");

    // erreur a décommenter pour voir le rollback
    $sql3 = "INSERT INTO post (title,content,user_id) VALUES ('".randomCaracteres(10,30)."','".randomCaracteres(150,300)."',5)";
    echo $request2 = $db->exec("$sql3");
    
    try{
        // validation de la transaction
        $db->commit();
    }catch(Exception $e){
        // bonne pratique, n'est pas obligatoire pour MySQL et MariaDB, efface TOUTES les modifications de la transaction
        $db->rollBack();
        echo $e->getMessage();
    }

    $datas = $query->fetchAll();
    var_dump($datas);

    ?>
    <h3>on utilise les transactions quand on manipule plusieures tables, et que l'on ne tolère pas l'erreur</h3>

    <h2>On utilise souvent les transactions dès qu'on a des tables liées</h2>

    <?php
    // arrêt de l'auto-commit
    $db->beginTransaction();

    // 1
    $sql1 = "INSERT INTO post (title,content,user_id) VALUES (?,?,?)";

    $title = ucfirst(randomCaracteres(20,50));
    $content = ucwords(randomCaracteres(200,500));
    $idUser = mt_rand(1,4);

    $prepare1 = $db->prepare($sql1);

    // les variables sont passées par références &$var et on peut les changer par la suite (mise en cache)
    $prepare1->bindParam(1,$title,PDO::PARAM_STR);
    $prepare1->bindParam(2,$content,PDO::PARAM_STR);
    $prepare1->bindParam(3,$idUser,PDO::PARAM_INT);

    $prepare1->execute();

    //2
    $title = ucfirst(randomCaracteres(20,50));
    $content = ucwords(randomCaracteres(200,500));
    $idUser = mt_rand(1,4);

    $prepare1->execute();

    //3
    $title = ucfirst(randomCaracteres(20,50));
    $content = ucwords(randomCaracteres(200,500));
    $idUser = mt_rand(1,4);

    $prepare1->execute();

    try{
        $db->commit();
    }catch(Exception $e){
        $db->rollBack();
        die ($e->getMessage());
    }
    ?>
</body>
</html>