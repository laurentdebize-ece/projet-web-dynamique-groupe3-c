<?php
require_once('fonction.php');
try {
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnes_my_skills;
charset=utf8', 'root', $mdp,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
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


/*
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
*/
/*
$tablo_compte_competence = [
    "ID_compte_competence" => null,
    "ID_Compte" => 3, 
    "ID_Competence" => 2,
    "Moyenne_professeur" => 18,
    "Etat_competence" => "noneva",
    "Competence_valide_etudiant" => "noneva",
    "Competence_valide_professeur" => "noneva",
    "Appreciation" => "tresgrosnul"

];
insertion($bdd, "compte_competence", $tablo_compte_competence);
*/
/*
$tablo_compte_matiere = [
    "ID_compte_matiere" => null,
    "ID_Compte" => 3, 
    "ID_Matiere" => 1
];
insertion($bdd, "compte_matiere", $tablo_compte_matiere);
*/
/*
$tablo_matiere_competence = [
    "ID_matiere_competence" => null,
    "ID_Matiere" => 1, 
    "ID_Competence" => 1,
    "Professeur" => "BONFILS"
];
insertion($bdd, "matiere_competence", $tablo_matiere_competence);
*/
/*
$tablo_compte = [
    "ID_Compte" => 1, //pas besoin de préciser un ID car il est en auto increment
    "Nom" => "ZIZOU",
    "Prenom" => "Bastien",
    "E_mail" => "ilrevient@gmail.com",
    "MDP" => "n2ggsz245",
    "Type_compte" => "Etudiant",
    "Deja_connecte" => 1,
    "ID_Ecole" => 3
];
insertion($bdd, "Compte", $tablo_compte);
*/
/*
$tablo_competence = [
    "ID_Competence" => null,
    "Nom" => "Maitrise_Python",
    "Date_Creation" => 2018,
    "Theme" => "Programmation"
];
insertion($bdd, "Competence", $tablo_competence)
*/
/*
$tablo_matiere = [
    "ID_Matiere" => null,
    "Nom" => "Mathematiques",
    "Volume_horaire" => 500
];
insertion($bdd, "Matiere", $tablo_matiere);
*/
/*
$tablo_ecole = [
    "ID_Ecole" => null,
    "Nom" => "ECAM"
];
insertion($bdd, "Ecole", $tablo_ecole);
*/
/*
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
*/


//TEST MULTIPLE JOINTURE

$reponseCompetence = "SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '1'
            GROUP BY Nom_matiere";

$exec = $bdd->prepare($reponseCompetence);
$exec->execute();

$resultat = $exec->fetchAll(PDO::FETCH_ASSOC);


foreach ($resultat as $reponses => $value) {
    echo $value["Nom_matiere"] ."<br>";
    echo $value["Nom_competence"] ."<br>";
    echo $value["Professeur"] ."<br>";
    echo $value["Etat_competence"] ."<br>";
    
}




?>