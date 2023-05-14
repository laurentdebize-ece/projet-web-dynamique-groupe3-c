
<?php
require_once('fonction.php');
try {
    $bdd = new PDO('mysql:host=localhost; 
charset=utf8',
        'root',
        'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

try {
    $bdd->exec('USE Omnes_my_skills;');
} catch (PDOException $e) {
    $sql = file_get_contents('./BDD/Omnes.sql');
    $bdd->exec($sql);
}

/*
$tablo = [
    "ID_Compte" => null, //pas besoin de préciser un ID car il est en auto increment
    "Nom" => "Renard",
    "Prenom" => "Arthur",
    "E_mail" => "arthur.renard@gmail.com",
    "MDP" => "4515",
    "Type_compte" => "Etudiant",
    "Deja_connecte" => 1,
    "ID_Ecole" => 1
];

var_dump($tablo);
insertion($bdd, "Compte", $tablo);
*/



$vachercher = jointure($bdd, "compte", "Ecole", "ID_Ecole", "ID_Ecole", "ID_Compte = 4");

foreach ($vachercher as $reponses => $value) {
    echo $value["ID_Compte"] ."<br>";
    echo $value["Nom"] ."<br>";
    echo $value["Prenom"] ."<br>";
    echo $value["E_mail"] ."<br>";
    echo $value["MDP"] ."<br>";
    echo $value["Type_compte"] ."<br>";
    echo $value["Deja_connecte"] ."<br>";
    echo $value["ID_Ecole"] ."<br>";
    
}
/*
$tablo = [
    "ID_compte_competence" => null,
    "ID_Compte" => 2, //pas besoin de préciser un ID car il est en auto increment
    "ID_Competence" => 2,
    "Moyenne_professeur" => 14,
    "Etat_competence" => "noneva",
    "Appreciation" => "tresgrosnul"

];
insertion($bdd, "compte_competence", $tablo);
*/

$doublejointure = doubleJointure($bdd, "compte", "compte_competence", "competence", "ID_Compte", "ID_Compte","ID_Competence", "ID_Competence", "compte.ID_Compte = 1"); //on peut mettre la condi que sur des attri de la première table 
foreach ($doublejointure as $reponses => $value) {
    echo $value["ID_Compte"] ."<br>";
    echo $value["Nom"] ."<br>";
    echo $value["Prenom"] ."<br>";
    echo $value["E_mail"] ."<br>";
    echo $value["MDP"] ."<br>";
    echo $value["Type_compte"] ."<br>";
    echo $value["Deja_connecte"] ."<br>";
    echo $value["ID_Ecole"] ."<br>";
    echo $value["ID_compte_competence"] ."<br>";
    echo $value["ID_Competence"] ."<br>";
    echo $value["Moyenne_professeur"] ."<br>";
    echo $value["Etat_competence"] ."<br>";
    echo $value["Appreciation"] ."<br>";
    
}
var_dump($doublejointure);

?>