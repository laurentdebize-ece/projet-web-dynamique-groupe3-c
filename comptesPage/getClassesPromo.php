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
//RECUPERATION DES DONNEES
$idPromo = $_GET['idPromo'];

$requete = $bdd->prepare('SELECT * FROM classe WHERE ID_Promotion = :idPromo');
$requete->bindParam(':idPromo', $idPromo);
$requete->execute();

$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<option value="'.$donnees['ID_Classe'].'">'.$donnees['Num_groupe'].'</option>';
}

echo $options;
?>