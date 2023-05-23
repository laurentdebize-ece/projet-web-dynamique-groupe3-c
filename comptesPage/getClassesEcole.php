<?php
//CONNEXION
try {
    $mdp = "root";
    if (strstr($_SERVER['DOCUMENT_ROOT'], "wamp")) {
        $mdp = ""; // pas de mdp sous wamp
    }
    $bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills; charset=utf8', 'root', $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
// RECUPERATION DES DONNEES
$idEcole = $_GET['idEcole'];

$requete = $bdd->prepare("SELECT * FROM ecole 
    INNER JOIN promotion ON ecole.ID_Ecole = promotion.ID_Ecole
    INNER JOIN classe ON promotion.ID_Promotion = classe.ID_Promotion
    WHERE ecole.ID_Ecole = :idEcole");
$requete->bindParam(':idEcole', $idEcole);
$requete->execute();

$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<input type="checkbox" name="classe[]" value="' . $donnees['ID_Classe'] . '">' . $donnees['Num_groupe'] . ' - ' . $donnees['Annee_fin'] . '<br>';
}

echo $options;
?>