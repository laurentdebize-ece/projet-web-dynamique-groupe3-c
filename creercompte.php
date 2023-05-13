<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

Email: <input type="text" name="Email2"><br>
Nom :  <input type="text" name="Nom2"><br>
Prenom :  <input type="text" name="Prenom2"><br> 
role:<br>
<input type="radio" name="role2" value="eleve"> éleve
<input type="radio" name="role2" value="prof">professeur
<input type="radio" name="role2" value="admin">administration
<br>
<input type="submit">
</form>

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
  header('Location: acceuil.php');      // location a modifier
  die();
}
$ID = $_SESSION['ID_compte'];

$reponse = $bdd->query('SELECT * FROM compte');
while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
			if ($donnees['Type_compte'] == 'admin') {
				echo 'Creation compte ';
				
				
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					
					$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$MDP2 = '';
					for ($i = 0; $i < 10; $i++) {
						$MDP2 .= $caracteres[rand(0, strlen($caracteres) - 1)];
					}
					
					$Email2 = $_POST['Email2'];
					$Typecompte2 = $_POST['role2'];
					$dejaco2 = 0;
					$nom2 = $_POST['Nom2'];
					$prenom2 = $_POST['Prenom2'];
					$IDecole=1;
					
					$requete = $bdd->prepare("INSERT INTO compte (Nom, Prenom, E_mail, MDP,type_compte, Déjà_connecté,ID_Ecole) VALUES ( :nom2, :prenom2, :Email2, :MDP2,:Typecompte2, :dejaco2, :IDecole)");
					$requete->bindParam(':nom2', $nom2);
					$requete->bindParam(':prenom2', $prenom2);
					$requete->bindParam(':Email2', $Email2);
					$requete->bindParam(':MDP2', $MDP2);
					$requete->bindParam(':Typecompte2', $Typecompte2);
					$requete->bindParam(':dejaco2', $dejaco2);
					$requete->bindParam(':IDecole', $IDecole);
					$requete->execute();
					
					
					
					
					echo "
					<script>
					alert('Compte créé');
					</script>";
					session_start();
					$_SESSION['ID_Compte'] = $ID;
					header('Location: acceuil.php');   // location a modifier
					exit();
			
				}
				
			}
			
		else{
			echo 'vous ne pouvez pas créer de comptes';
		}
				
			
		}
}
		

?>
</body>
</html>