<!DOCTYPE html>
<html>
<body>


<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnes_my_skills; 
    charset=utf8', 'root', $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>


<?php
session_start();
if (!isset($_SESSION['ID_compte'])) {
    header('Location: ../connexionPage/premiereconnexion.php');
    exit();
}
$ID = $_SESSION['ID_compte'];
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<?php
$reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_competence ON Compte.ID_compte = compte_competence.ID_compte INNER JOIN competence ON compte_competence.ID_competence = competence.ID_competence');
while ($donnees = $reponse->fetch()){
    if ($donnees['ID_Compte'] == $ID) {
        echo $donnees['Nom_competence' ];
        echo '<input type="radio" name="autoeval" value="nonacquis">'. "non acquis";
        echo '<input type="radio" name="autoeval" value="encoursacquis">'."en cours d'acquisition" ;
        echo '<input type="radio" name="autoeval" value="acquis">'. "acquis";
        echo '<input type="submit">' . '<br>';
    }
}
?>
</form>




<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // code sql pour attribuer l'eval 
    }
?>


</body>
</html>
