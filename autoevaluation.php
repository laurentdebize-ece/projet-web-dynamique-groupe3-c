<!DOCTYPE html>
<html>
<body>


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
if (!isset($_SESSION['ID_compte'])&& !isset($_SESSION['Nom_Matiere_Choisie'])) {
    header('Location: matiereChoisie.php');
    exit();
}
$ID = $_SESSION['ID_Compte'];
$NomMatiere=$_SESSION['Nom_Matiere_Choisie'];
?>
<?php echo $ID?>

<?php
$reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_competence ON Compte.ID_compte = compte_competence.ID_compte INNER JOIN competence ON compte_competence.ID_competence = competence.ID_competence INNER JOIN matiere_competence ON competence.ID_competence = matiere_competence.ID_Competence INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere');
while ($donnees = $reponse->fetch()){
    if ($donnees['ID_Compte'] == $ID && $donnees['Nom_matiere']==$NomMatiere ) { ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <?php echo $donnees['Nom_competence' ]; 
        $idcompet =$donnees['ID_compte_competence']; ?>
        <input type="radio" name=" <?php echo $idcompet; ?>" value="nonacquis"> non acquis.
        <input type="radio" name=" <?php echo $idcompet;?>" value="encoursacquis">en cours d'acquisition
        <input type="radio" name=" <?php echo $idcompet; ?>" value="acquis">acquis
        <br><br>
    <?php
    }
}?>
<input type="submit" name="submit" value="Evaluer">
    </form>




<?php
if (isset($_POST['submit'])) {
    foreach ($_POST as $idcompet => $value) {
        if ($idcompet != "submit") {
            echo "Compétence évaluée : " . $idcompet . "<br>";
            echo "Note : " . $value . "<br>";

            $sql ="UPDATE compte_competence SET Etat_competence='$value' WHERE ID_Compte = '$ID' AND ID_compte_competence = '$idcompet'";
            $bdd -> query($sql);
        }
    }
}
?>


</body>
</html>
