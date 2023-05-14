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
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$reponse = $bdd->query('SELECT * FROM compte');
$identifiants_corrects = false;
	while ($donnees = $reponse->fetch()){
		if ($donnees['E_mail'] == $_POST['mail'] && $donnees['MDP'] == $_POST['motdepasse']) {
			$mail = $donnees['E_mail'];
			$ID = $donnees['ID_Compte'];
			$identifiants_corrects = true;
			break;
		}
	}	
		if($identifiants_corrects) {
			session_start();
			$_SESSION['ID_Compte'] = $ID;
			header('Location: premiereconnexion.php');
			exit();
		}
		else {
			header('Location: connexionPage.html?error=wrongpassword');
        	exit();
		}
}
?>

</body>
</html>