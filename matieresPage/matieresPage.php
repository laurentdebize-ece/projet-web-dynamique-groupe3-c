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

session_start();
if (!isset($_SESSION['ID_Compte']) && !isset($_SESSION['Type_compte'])) {
	header('Location: ../connexionPage/premiereconnexion.php');
	exit();
  }
$ID = $_SESSION['ID_Compte'];
$Type_compte = $_SESSION['Type_compte'];
$_SESSION['ID_Compte'] = $ID;
$_SESSION['Type_compte'] = $Type_compte;
$NomMatiere=$_SESSION['Nom_Matiere_Choisie'];

require_once('../fonction.php');

if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_matiere" => NULL,
        "Nom_matiere" => $_POST['NewNom'],
        "Volume_horaire" => $_POST['NewVolumeHoraire']
    ];
    insertion($bdd,"matiere", $tab_matiere);
}
if(isset($_POST['validerModification'])){
    if($_POST['NewNom']!=''){
        $NewNom=$_POST['NewNom'];
        $modificationMatiere = "UPDATE matiere SET Nom_matiere = '$NewNom' WHERE Nom_matiere='$NomMatiere'";
		$bdd->query($modificationMatiere);
    }
    if($_POST['NewVolumeHoraire']!=''){
        $NewVolumeHoraire=$_POST['NewVolumeHoraire'];
        $modificationMatiere = "UPDATE matiere SET Volume_horaire = '$NewVolumeHoraire' WHERE Nom_matiere='$NomMatiere'";
		$bdd->query($modificationMatiere); 
    }
}
if(isset($_POST['validerSuppression'])){
if($_POST['validerSuppression']=="Valider"){
    $reponse=$bdd->query("SELECT ID_Matiere FROM matiere WHERE Nom_matiere='$NomMatiere'");
    while ($donnees = $reponse->fetch()){ 
        $recupIdMatiere=$donnees['ID_Matiere'];
    }
    $sql1="DELETE FROM compte_matiere WHERE compte_matiere.ID_Matiere=$recupIdMatiere";
    $sql2="DELETE FROM matiere_competence WHERE matiere_competence.ID_Matiere=$recupIdMatiere";
    $sql3="DELETE FROM matiere WHERE ID_Matiere=$recupIdMatiere";
    $stmt1=$bdd->prepare($sql1);
    $stmt2=$bdd->prepare($sql2);
    $stmt3=$bdd->prepare($sql3);
    $stmt1->execute();
    $stmt2->execute();
    $stmt3->execute();
}
}
if(isset($_POST['validerAjoutProf'])){
    if($_POST['validerAjoutProf']=="Valider"){
        $reponse=$bdd->query("SELECT ID_Matiere FROM matiere WHERE Nom_matiere='$NomMatiere'");
        while ($donnees = $reponse->fetch()){ 
            $recupIdMatiere=$donnees['ID_Matiere'];
        }
        $tab_compte_matiere = [
            "ID_compte_matiere" => NULL,
            "ID_Compte" => $_POST['professeurSelect'],
            "ID_Matiere" => $recupIdMatiere
        ];
        insertion($bdd,"compte_matiere", $tab_compte_matiere);//Au secourssssssss
    }
}
if($Type_compte=="Administrateur"){
    $reponseMatiere = $bdd->query("SELECT Nom_matiere FROM matiere");
} else {
    $reponseMatiere = $bdd->query("SELECT Nom_matiere FROM matiere 
        INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
        INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
        WHERE compte.ID_Compte = '$ID'");
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Mes matières</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleMatieres.css" rel="stylesheet" type="text/css">
</head>

<body>
<section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
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
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="bodyMesMatieres">
        <form method="POST" action="matiereChoisie.php">
            <?php while($donneesMatiere = $reponseMatiere->fetch()) {  ?>
                <input type="submit" name ="Matiere" value= <?php echo $donneesMatiere['Nom_matiere'];?> class="boutonMatiere">
                <?php } ?>
        </form>
        </section>
        <?php if($Type_compte=="Administrateur"){?>
            <div class="login-form3">
                <form method="POST" action="modifMatiere.php" id="formModifMatiere">
                    <input type="submit" name ="modifMatiere" value="Ajouter" class="boutonModif">
                </form>
            </div>
        <?php }
?>

    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>