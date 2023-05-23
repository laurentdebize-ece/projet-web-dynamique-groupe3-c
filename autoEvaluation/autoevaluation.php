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

//RECUPERATION DES DONNEES
session_start();
if (!isset($_SESSION['ID_compte']) && !isset($_SESSION['Nom_Matiere_Choisie']) && !isset($_SESSION['Type_compte'])) {
    header('Location: matiereChoisie.php');
    exit();
}
$ID = $_SESSION['ID_Compte'];
$NomMatiere=$_SESSION['Nom_Matiere_Choisie'];
$Type_compte=$_SESSION['Type_compte'];
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Auto-évaluation</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleAutoEvaluation.css" rel="stylesheet" type="text/css">
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
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="competencesParMatiere">



<table>
    
    <?php //AUTO EVALUATION D'UN ELEVE
    $reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_competence ON Compte.ID_compte = compte_competence.ID_compte INNER JOIN competence ON compte_competence.ID_competence = competence.ID_competence INNER JOIN matiere_competence ON competence.ID_competence = matiere_competence.ID_Competence INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere');
    while ($donnees = $reponse->fetch()){
        if ($donnees['ID_Compte'] == $ID && $donnees['Nom_matiere']==$NomMatiere ) { ?>
            <tr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <td><?php echo $donnees['Nom_competence' ]; 
                $idcompet =$donnees['ID_compte_competence']; ?></td>
                <td><input type="radio" name=" <?php echo $idcompet; ?>" value="nonacquis"> non acquis</td>
                <td><input type="radio" name=" <?php echo $idcompet;?>" value="encoursacquis">en cours d'acquisition</td>
                <td><input type="radio" name=" <?php echo $idcompet; ?>" value="acquis">acquis</td>
                <br><br>
        <?php
        }
    }?>
    <div class="login-form4">
        <input type="submit" name="submit" value="Evaluer">
</form>
</div>
</tr>



    <?php
    if (isset($_POST['submit'])) {
        foreach ($_POST as $idcompet => $value) {
            if ($idcompet != "submit") {
                $sql ="UPDATE compte_competence SET Etat_competence='$value' WHERE ID_Compte = '$ID' AND ID_compte_competence = '$idcompet'";
                $bdd -> query($sql);
                $sql ="UPDATE compte_competence SET Competence_valide_etudiant='valide' WHERE ID_Compte = '$ID' AND ID_compte_competence = '$idcompet'";
                $bdd -> query($sql);
            }
        }
    }
    ?>
</table>
<footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>
</html>
