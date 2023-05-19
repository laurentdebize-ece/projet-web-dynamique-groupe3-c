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
require_once('../fonction.php');
$Nom_Matiere_Choisie = $_POST['Matiere'];
$_SESSION['Nom_Matiere_Choisie']=$Nom_Matiere_Choisie;
?>
<div class="login-form3">
    <?php 
    if($Type_compte=="Etudiant"){?>
                <form method="POST" action="../autoevaluation.php" id="AutoEval">
                <?php echo '<span style="font-family: openSansLight;">faire une auto-evaluation</span>' ?>
                <input type="submit" name ="faireEval" value="s'auto evaluer" class="boutonAutoEval">
                </form>
                <?php }

    if($Type_compte=="admin"){
        $reponseCompetence = $bdd->query("SELECT * FROM matiere
            INNER JOIN matiere_competence ON matiere.ID_matiere = matiere_competence.ID_matiere
            INNER JOIN competence ON matiere_competence.ID_competence = competence.ID_competence");
    }

    else {
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
        INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
        INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
        INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
        INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
        WHERE compte.ID_Compte = '$ID'
        AND matiere.Nom_Matiere = '$Nom_Matiere_Choisie'");
    }
    ?>
</div>

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
            <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
            <?php }
            if($Type_compte=="Professeur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
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
    <div class="login-form3">
        <table>
        <tr id="textLigne1">
            <th>Compétences</th>
            <th>Compétences</th>
            <th>Matière</th>
            <th>Etat de la compétence</th>
        </tr>
    <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
        <tr>
            <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
            <td id="textColonne"><?php echo $donneesCompetence['ID_Competence']?></td>
            <td id="textColonne"><?php echo $donneesCompetence['Nom_matiere']?></td>
            <td class="textColonne"><?php echo $donneesCompetence['Etat_competence']?></td>
        </tr>
    <?php } ?>
    </table>
    <?php if($Type_compte=="Administrateur"){?>
                <form method="POST" action="modifMatiere.php"  id="formModifMatiere">
                    <input type="submit" name ="modifMatiere" value="Supprimer" class="boutonModif">
                    <input type="submit" name ="modifMatiere" value="Modifier" class="boutonModif">
                </form>
            <?php }?>
    </div>        
        </section>
    
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>