<?php

//CONNEXION
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills; 
    charset=utf8', 'root', $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
//RECUPERATION DES DONNES
$idEcole = $_GET['idEcole'];

$requete = $bdd->prepare('SELECT * FROM promotion WHERE ID_Ecole = :idEcole');
$requete->bindParam(':idEcole', $idEcole);
$requete->execute();

$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<option value="'.$donnees['ID_Promotion'].'">'.$donnees['Annee_fin'].'</option>';
}

echo $options;
?>