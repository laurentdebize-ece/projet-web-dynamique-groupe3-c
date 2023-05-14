<!DOCTYPE html>
<html>
<body>

<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $passeword="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
?>

<?php
$verif =0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$reponse = $bdd->query('SELECT * FROM compte');
// On affiche chaque entree une a une
	while ($donnees = $reponse->fetch()){
		if ($donnees['E_mail'] == $_POST['mail'] && $donnees['MDP'] == $_POST['motdepasse']) {
			$mail = $donnees['E_mail'];
			$ID = $donnees['ID_Compte'];
			$verif = 1;
			break;
		}
	}	
		if($verif == 1) {
			session_start();
			$_SESSION['ID_Compte'] = $ID;
			header('Location: premiereconnexion.php');
			exit();
		}
		else {
			session_start();
			header('Location: connexionPage.html');
			exit();
		}
}
?>

</body>
</html>