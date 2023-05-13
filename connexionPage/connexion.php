<!DOCTYPE html>
<html>
<body>

<?php
try{
$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', 'root',
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
			echo "Pseudo ou mot de passe erroné veuillez réessayer.";
		}
}
?>

<?php
/*
$login = 'test1';
$pass = 'test12';
$verif=0;

$tableau = array(
array('login1','pass1','0'),
array('login2','pass2','1'),
array('login3','pass3','admin'),
array('login4','pass4','eleve'),
array('login5','pass5','prof')
);


?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  for ($i = 0; $i < count($tableau); $i++) {
    if ($tableau[$i][0] == $_POST['pseudo'] && $tableau[$i][1] == $_POST['motdepasse']) {
      $pseudo = $tableau[$i][0];
      $motdepasse = $tableau[$i][1];
      $type = $tableau[$i][2];
      $verif = 1;
      break;
    }
  }
  if ($verif == 1) {
		session_start();
		$_SESSION['pseudo'] = $pseudo;
		$_SESSION['motdepasse'] = $motdepasse;
		$_SESSION['type'] = $type;
		header('Location: MDP.php');
		exit();
  }
  else {
    echo "Pseudo ou mot de passe erroné veuillez réessayer.";
  }
}*/
?>

</body>
</html>