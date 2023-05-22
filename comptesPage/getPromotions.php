<?php

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

// Récupérer l'ID de l'école depuis la requête GET
$idEcole = $_GET['idEcole'];

// Effectuer la requête pour récupérer les promotions associées à l'école
$requete = $bdd->prepare('SELECT * FROM promotion WHERE ID_Ecole = :idEcole');
$requete->bindParam(':idEcole', $idEcole);
$requete->execute();

// Construire les options du menu déroulant des promotions
$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<option value="'.$donnees['ID_Promotion'].'">'.$donnees['Annee_fin'].'</option>';
}

// Retourner les options au format HTML
echo $options;
?>