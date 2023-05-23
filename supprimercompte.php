<!DOCTYPE html>
<html>
<body>

//CONNEXION
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


//RECUPERATION DES DONNEES
<?php
session_start();
if (!isset($_SESSION['ID_compte'])) {
    header('Location: ...');   //location a definir
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
//SUPPRIMER UN COMPTE
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['ID2']== $donnees['ID_Compte'] && $_POST['ID2'] != $ID) {
            $comptesup=$_POST['ID2'];
            $sql = "DELETE FROM compte WHERE ID_Compte='$comptesup'"; //rajouter pour aussi les tables compte_comptetence et compte_matiere
            $bdd->query($sql);
            echo "<script>alert('Compte supprimé');</script>";
            session_start();
            $_SESSION['ID_Compte'] = $ID;
            header('Location: ...');   //location a definir
            exit();
        } else {
            echo "impossible de supprimer ce compte. <br>";
        }
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<?php
echo "Sélectionner le compte à supprimer : <br>";
$reponse = $bdd->query('SELECT * FROM compte');
while ($donnees = $reponse->fetch()){
    if ($donnees['ID_Compte'] != $ID) {
        echo '<input type="radio" name="ID2" value="' . $donnees['ID_Compte'] . '"> ' . $donnees['Nom'] . ' ' . $donnees['Prenom'] . '<br>';
    }
}
?>

<input type="submit">
</form>


</body>
</html>
