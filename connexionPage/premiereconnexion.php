<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Connexion</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleConnexionPage.css" rel="stylesheet" type="text/css">
</head>
<body class="connexionPage">
<section>
        <img src="../img/omnesSkills.png"  alt=" omnesSkills " id="tailleImgOmnesSkillsConnexionPage">
        <section>
        <div class="login-form">
            <h3>Première connexion</h3>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				Modifiez votre mot de passe : <br><input type="password" name="motdepasse" placeholder="Entrez votre mot de passe" required><br><br>
				Réécrivez votre mot de passe : <br><input type="password" name="Nmotdepasse" placeholder="Entrez à nouveau votre mot de passe" required><br><br>
				<input type="submit" value="Connexion">
			</form>
            <div id="errorMessage"></div>
        </div>
    </section>  
 <footer>
    <div class="floatLeft">Projet Développement Web</div>
    <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>

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
?>

<?php

//RECUPERATION DES DONNEES
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
		if ($donnees['Deja_connecte']=='0'){
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if ($_POST['motdepasse']== $_POST['Nmotdepasse']) {
						$motdepasse = $_POST['motdepasse'];
						$type = 1;
						$verif = 1;
						$sql = "UPDATE compte SET MDP='$motdepasse', Deja_connecte='$type' WHERE ID_Compte='$ID'";
						$bdd->query($sql);
					}
}
					if($verif == 1) {
						session_start();
						$_SESSION['ID_Compte'] = htmlspecialchars($ID, ENT_QUOTES, 'UTF-8');
						$_SESSION['Type_compte'] = htmlspecialchars($Type_compte, ENT_QUOTES, 'UTF-8') ;
						header('Location: ../homePage/homePage.php');						
						exit();
					}
					else {
						echo "Nouveau mot de passe invalide.";
					}
				}
			else if (($donnees['Deja_connecte']=='1')) {

				session_start();
				$_SESSION['ID_Compte'] = htmlspecialchars($ID, ENT_QUOTES, 'UTF-8');
				$_SESSION['Type_compte'] = htmlspecialchars($Type_compte, ENT_QUOTES, 'UTF-8');
				header('Location: ../homePage/homePage.php');
				exit();
			}
		}
}	
?>

</body>
</html>