<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

ne pas remplir le champ si vous voulez pas modifier un element
<br>

Nom : <input type="text" name="Newnom"><br>
Prenom : <input type="text" name="Newprenom"><br>
Email : <input type="text" name="Newmail"><br>


Nouveau mot de passe: <input type="password" name="motdepasse"><br>
réécrivez votre  nouveau mot de passe: <input type="password" name="Nmotdepasse"><br>
<input type="submit">
</form>
<?php
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

<?php
session_start();
if (!isset($_SESSION['ID_Compte'])) {
  header('Location: profilPage.php');
  exit();
}
$ID = $_SESSION['ID_Compte'];
$verifmdp = 0;
$verifmail = 0;
$verifnom = 0;
$verifprenom = 0;
?>



<?php
$reponse = $bdd->query('SELECT * FROM compte');

while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if ($_POST['motdepasse']== $_POST['Nmotdepasse']) {
						$verifmdp = 1;
						if ( $_POST['motdepasse']!="" && $_POST['Nmotdepasse']!=""){
							$motdepasse = $_POST['motdepasse'];
							$sql = "UPDATE compte SET MDP='$motdepasse' WHERE ID_Compte='$ID'";
							$bdd->query($sql);						
						}
						
					}
					
					if ($_POST['Newmail']!="") {
						$verifmail = 1;
						$Newmail = $_POST['Newmail'];
						$sql = "UPDATE compte SET E_mail='$Newmail' WHERE ID_Compte='$ID'";
						$bdd->query($sql);						
					}
					
					if ($_POST['Newnom']!="") {
						$verifnom = 1;
						$Newnom = $_POST['Newnom'];
						$sql = "UPDATE compte SET Nom='$Newnom' WHERE ID_Compte='$ID'";
						$bdd->query($sql);						
						
						
					}
					if ($_POST['Newprenom']!="") {
						$verifprenom = 1;
						$Newprenom = $_POST['Newprenom'];
						$sql = "UPDATE compte SET Prenom='$Newprenom' WHERE ID_Compte='$ID'";
						$bdd->query($sql);								
}
					if($verifmdp == 1 || $verifmail==1 ||$verifnom==1 || $verifprenom==1) {
						session_start();
						$_SESSION['ID_Compte'] = $ID;
						header('Location: profilPage.php');
						exit();
					}
		}
}	
?>

</body>
</html>