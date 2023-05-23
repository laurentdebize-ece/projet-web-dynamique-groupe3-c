<?php

require_once('fonction.php');


///////////////////////////////////////////////////CONNEXION BDD/////////////////////////////////////////////////
try {
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', $mdp,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

try {
    $bdd->exec('USE omnesmyskills;');
} catch (PDOException $e) {
    $sql = file_get_contents('./BDD/Omnes.sql');
    $bdd->exec($sql);
}
///////////////////////////////////////////////////INSERTION COMPTE////////////////////////////////////////////
/*
$tablo_compte = [
    "ID_Compte" => null, //pas besoin de préciser un ID car il est en auto increment
    "Nom_Compte" => "ARRIETA",
    "Prenom" => "Lukeh",
    "E_mail" => "iso@gmail.com",
    "MDP" => "aetsxeb45",
    "Type_compte" => "Professeur",
    "Deja_connecte" => 1,
    "ID_Ecole" => 1
];
insertion($bdd, "Compte", $tablo_compte);
*/
/*
$tablo_classe = [
    "ID_Classe" => null,
    "Num_groupe" => "3",
    "Nombre_etudiant" => "30",
    "ID_Promotion" => 1
];
insertion($bdd, "Classe", $tablo_classe);

$tablo_promotion = [
    "ID_Promotion" => null,
    "Annee_debut" => "2008",
    "Annee_fin" => "2013",
    "ID_Ecole" => 2
];
insertion($bdd, "Promotion", $tablo_promotion);
//////////////////////////////////////////INSERTION COMPTE_COMPETENCE////////////////////////////////////////////
/*
/*
$tablo_compte_competence = [
    "ID_compte_competence" => null,
    "ID_Compte" => 2, 
    "ID_Competence" => 2,
    "Moyenne_professeur" => 14,
    "Etat_competence" => "noneva",
    "Competence_valide_etudiant" => "noneva",
    "Competence_valide_professeur" => "noneva",
    "Appreciation" => "grosnul"

];
insertion($bdd, "compte_competence", $tablo_compte_competence);
*/


//////////////////////////////////////////INSERTION COMPTE_MATIERE////////////////////////////////////////////
/*
$tablo_compte_matiere = [
    "ID_compte_matiere" => null,
    "ID_Compte" => 7, 
    "ID_Matiere" => 2
];
insertion($bdd, "compte_matiere", $tablo_compte_matiere);
*/



//////////////////////////////////////////INSERTION MATIERE_COMPETENCE////////////////////////////////////////////
/*
$tablo_matiere_competence = [
    "ID_matiere_competence" => null,
    "ID_Matiere" => 3, 
    "ID_Competence" => 2,
    "Professeur" => "HINTZY"
];
insertion($bdd, "matiere_competence", $tablo_matiere_competence);
*/


///////////////////////////////////INSERTION COMPETENCE ET EN MM TEMPS DANS METIERE_COMPETENCE//////////////////////////////////////////

$tablo_competence = [
    "ID_Competence" => null,
    "Nom_Competence" => $recupNom = "Maitrise_Python5",
    "Date_Creation" => $recupDate = "2018-05-17",
    "Theme" => "Programmation"
];
insertion($bdd, "Competence", $tablo_competence);

$sql = "SELECT ID_Competence FROM Competence WHERE Nom_Competence ='$recupNom' AND Date_Creation = '$recupDate'";

$exec = $bdd->prepare($sql);
$exec->execute();

$ID_matiere_competence = $exec->fetchAll(PDO::FETCH_ASSOC);

$tablo_matiere_competence = [
    "ID_matiere_competence" => null,
    "ID_Matiere" => 3, 
    "ID_Competence" => $ID_matiere_competence[0]['ID_Competence'],
    "Professeur" => "HINTZYLE10E"
];
insertion($bdd, "matiere_competence", $tablo_matiere_competence);


//////////////////////////////////////////INSERTION MATIERE///////////////////////////////////////////
/*
$tablo_matiere = [
    "ID_Matiere" => null,
    "Nom" => "Mathematiques",
    "Volume_horaire" => 500
];
insertion($bdd, "Matiere", $tablo_matiere);
*/

//////////////////////////////////////////INSERTION ECOLE////////////////////////////////////////////   
/*
$tablo_ecole = [
    "ID_Ecole" => null,
    "Nom" => "ECAM"
];
insertion($bdd, "Ecole", $tablo_ecole);
*/

/*
supprimer_compte($bdd,"compte","compte_competence","compte_matiere","4");
*/

?>