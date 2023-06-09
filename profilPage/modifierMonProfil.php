<?php
//Connexion au serveur
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', $mdp,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
?>

//RECUPERATION DES DONNEES
<?php
session_start();
if (!isset($_SESSION['ID_Compte'])) {
  header('Location: profilPage.php');
  exit();
}
$ID = $_SESSION['ID_Compte'];
$Type_compte = $_SESSION['Type_compte'];
$verifmdp = 0;
$verifmail = 0;
$verifnom = 0;
$verifprenom = 0;
$erreur=0;
$reponse = $bdd->query('SELECT * FROM compte');

while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if ($_POST['mdp1']== $_POST['mdp2']) {
						$verifmdp = 1;
						if ( $_POST['mdp1']!="" && $_POST['mdp2']!=""){
							$motdepasse = htmlspecialchars($_POST['mdp1'], ENT_QUOTES, 'UTF-8');
							$sql = "UPDATE compte SET MDP='$motdepasse' WHERE ID_Compte='$ID'";
							$bdd->query($sql);
						}
						
					}else {
						$erreur=1;
					}
					if($Type_compte=="Administrateur"){
					if ($_POST['Newmail']!="") {
						$verifmail = 1;
						$Newmail =htmlentities($_POST['Newmail'], ENT_QUOTES, 'UTF-8');
						$sql = "UPDATE compte SET E_mail='$Newmail' WHERE ID_Compte='$ID'";
						$bdd->query($sql);						
					}
					
					if ($_POST['Newnom']!="") {
						$verifnom = 1;
						$Newnom = htmlspecialchars($_POST['Newnom'], ENT_QUOTES, 'UTF-8');
						$sql = "UPDATE compte SET Nom_Compte ='$Newnom' WHERE ID_Compte='$ID'";
						$bdd->query($sql);						
						
					}
					if ($_POST['Newprenom']!="") {
						$verifprenom = 1;
						$Newprenom = htmlspecialchars($_POST['Newprenom'], ENT_QUOTES, 'UTF-8');
						$sql = "UPDATE compte SET Prenom='$Newprenom' WHERE ID_Compte='$ID'";
						$bdd->query($sql);								
}					}
					if($verifmdp == 1 || $verifmail==1 ||$verifnom==1 || $verifprenom==1) {
						session_start();
						$_SESSION['ID_Compte'] = $ID;
						header('Location: profilPage.php');
						exit();
					}
				}
			}
}	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Modifier compte</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleProfilPage.css" rel="stylesheet" type="text/css">
</head>

<body>
<section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.php" class="lienWhite">Compétences transverses</a></div>
                <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <?php }
            if($Type_compte=="Professeur"){ ?>
                <div class="flexboxText-menu"><a href="../evaluationsPage/evaluationsPage.php" class="lienWhite">Evaluations</a></div>
            <?php }
            if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="profilPage.php" class="lienClique"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
//MODIFICATION DE CHAMPS
	<section>
		<img src="../img/paris.jpg"  alt="parisCity" class="tailleImgFormualaire"><!--http://wikimapia.org/5009811/fr/Paris-->
		<div id="formulaireModificationProfil">	
			<div class="login-form2">
				<h3>Mon compte</h3>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<?php if($Type_compte == "Administrateur") { ?>
						Ne pas remplir le champ si vous ne voulez pas modifier l'element.<br><br>
						Nom : <input type="text" name="Newnom" placeholder="Changer nom"><br><br>
						Prénom : <input type="text" name="Newprenom" placeholder="Changer prénom"><br><br>
						Email : <input type="mail" name="Newmail" placeholder="Changer Adresse mail"><br><br>
						<label for="motdepasse1">Nouveau mot de passe :</label>
						<input type="password" name="mdp1" placeholder="Nouveau mot de passe"><br><br>
						<label for="motdepasse2">Réécrivez votre nouveau mot de passe :</label>
						<input type="password" name="mdp2" placeholder="Confirmez mot de passe"><br><br>
					<?php }
					else { ?>
						<label for="motdepasse1">Nouveau mot de passe :</label>
						<input type="password" name="mdp1" placeholder="Nouveau mot de passe" required><br><br>
						<label for="motdepasse2">Réécrivez votre nouveau mot de passe :</label>
						<input type="password" name="mdp2" placeholder="Confirmez mot de passe" required><br><br>
						<?php if($erreur!=0){ ?>
							<p style='color:red'>Veuillez rentrer des mots de passe identiques.<br></p>
						<?php }
					} ?>
					<input type="submit" value="modifier"><br>
				</form>
			</div>
		</div>
	</section> 
	<footer>
    	<div class="floatLeft">Projet Développement Web</div>
    	<div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>
</html>

