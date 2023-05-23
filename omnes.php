<?php
//CONNEXION
require_once('fonction.php');
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


/*
$vachercher = jointure($bdd, "compte", "Ecole", "ID_Ecole", "ID_Ecole", "ID_Compte = 1");

foreach ($vachercher as $reponses => $value) {
    echo $value["ID_Compte"] ."<br>";
    echo $value["Nom_Compte"] ."<br>";
    echo $value["Prenom"] ."<br>";
    echo $value["E_mail"] ."<br>";
    echo $value["MDP"] ."<br>";
    echo $value["Type_compte"] ."<br>";
    echo $value["Deja_connecte"] ."<br>";
    echo $value["ID_Ecole"] ."<br>";
    
}
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
/*
$reponseCompetence = /*"SELECT DISTINCT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere 
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere 
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte 
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte 
            WHERE compte_matiere.ID_Compte = '1'";
*/
/*
            "SELECT DISTINCT * FROM compte 
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            WHERE compte.ID_Compte = '1'";

$exec = $bdd->prepare($reponseCompetence);
$exec->execute();

$resultat = $exec->fetchAll(PDO::FETCH_ASSOC);


foreach ($resultat as $reponses => $value) {
    echo $value["Nom_matiere"] ."<br>";
    echo $value["ID_Matiere"] ."<br>";
    echo $value["Nom_competence"] ."<br>";
    echo $value["Professeur"] ."<br>";
    //echo $value["Etat_competence"] ."<br>";
    echo $value["ID_Competence"] ."<br>";
    
}

/*
$sql = "SELECT Nom_competence FROM competence";

$exec = $bdd->prepare($sql);
$exec->execute();

$resultat = $exec->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultat as $reponses => $value) {
    echo $value["Nom_competence"] ."<br>";
}
*/

/*
$resultat = selection_nouvelles_competences($bdd,"2","physique");

foreach ($resultat as $reponses => $value) {

    echo $value["Nom_competence"] ."<br>";
    echo $value["ID_Competence"] ."<br>";
    
}
?>*/