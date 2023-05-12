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
session_start();
if (!isset($_SESSION['ID_compte'])) {
  header('Location: accueil.php');   // location a modifier
  exit();
}
$ID = $_SESSION['ID_compte'];

$reponse = $bdd->query('SELECT * FROM compte');
while ($donnees = $reponse->fetch()){
	
			echo 'Nom: ';
			echo $donnees['Nom'];
			echo '     Prenom: ';
			echo $donnees['Prenom'];
			echo '<br>Role: ';
			echo $donnees['Type_compte'];
			echo '<br>Identifiant: ';
			echo $donnees['ID_Compte'];
		    echo '<br> <br>';
			
			
			
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if ($_POST['ID2']== $donnees['ID_Compte'] && $_POST['ID2'] != $ID) {
						$comptesup=$_POST['ID2'];
						$sql = "DELETE FROM compte WHERE ID_Compte='$comptesup'";
						$bdd->query($sql);
						echo "
					<script>
					alert('Compte supprimé');
					</script>";
					session_start();
					$_SESSION['ID_Compte'] = $ID;
					header('Location: acceuil.php');  // location a modifier
					exit();
}
					else {
						echo "impossible de supprimer ce compte. <br>";
					}
				}
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

Identifiant du compte a supprimer : <input type="text" name="ID2"><br>
<input type="submit">
</form>


</body>
</html>