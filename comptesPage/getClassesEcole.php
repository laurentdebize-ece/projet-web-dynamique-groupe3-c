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

$idEcole = $_GET['idEcole'];

$requete = $bdd->prepare('SELECT * FROM classe 
    INNER JOIN promotion ON classe.ID_Promotion = promotion.ID_Promotion
    INNER JOIN ecole ON promotion.ID_Ecole = ecole.ID_Ecole
    WHERE ID_ecole = :idEcole');
$requete->bindParam(':idEcole', $idEcole);
$requete->execute();

$options = '';
while ($donnees = $requete->fetch()) {
    $options .= '<option value="'.$donnees['ID_Classe'].'">'.$donnees['Num_groupe'].'</option>';
}

echo $options;
?>