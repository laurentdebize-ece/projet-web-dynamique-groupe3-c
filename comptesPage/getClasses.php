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
$idPromo = $_GET['idPromo'];

// Effectuer la requête pour récupérer les promotions associées à l'école
$requete = $bdd->prepare('SELECT * FROM classe WHERE ID_Promotion = :idPromo');
$requete->bindParam(':idPromo', $idPromo);
$requete->execute();

// Construire les options du menu déroulant des promotions
$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<option value="'.$donnees['ID_Classe'].'">'.$donnees['Num_groupe'].'</option>';
}

// Retourner les options au format HTML
echo $options;
?>