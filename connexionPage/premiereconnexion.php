<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

1ere connexion
modifier votre mot de passe: <input type="password" name="motdepasse"><br>
réécrivez votre mot de passe: <input type="password" name="Nmotdepasse"><br>
<input type="submit">
</form>

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
?>

<?php
session_start();

if (!isset($_SESSION['ID_Compte'])) {
	header('Location: connexion.php');
	exit();
  }
$ID = $_SESSION['ID_Compte'];
$verif=0;
?>


<?php
$reponse = $bdd->query('SELECT * FROM compte');

while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
		$Type_compte=$donnees['Type_compte'];
		if ($donnees['Déjà_connecté']=='0'){
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if ($_POST['motdepasse']== $_POST['Nmotdepasse']) {
						$motdepasse = $_POST['motdepasse'];
						$type = 1;
						$verif = 1;
						$sql = "UPDATE compte SET MDP='$motdepasse', Déjà_connecté='$type' WHERE ID_Compte='$ID'";
						$bdd->query($sql);
					}
}
					if($verif == 1) {
						session_start();
						$_SESSION['ID_Compte'] = $ID;
						$_SESSION['Type_compte'] = $Type_compte;
						header('Location: ../homePage/homePage.php');						
						exit();
					}
					else {
						echo "Nouveau mot de passe invalide.";
					}
				}
			else {
				

				session_start();
				$_SESSION['ID_Compte'] = $ID;
				$_SESSION['Type_compte'] = $Type_compte;
				header('Location: ../homePage/homePage.php');
				exit();
			}
		}
}	
?>

</body>
</html>