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
if (!isset($_SESSION['ID_Compte']) && !isset($_SESSION['Type_compte'])) {
	header('Location: ../connexionPage/premiereconnexion.php');
	exit();
  }
$ID = $_SESSION['ID_Compte'];
$Type_compte = $_SESSION['Type_compte'];
$_SESSION['ID_Compte'] = $ID;
$_SESSION['Type_compte'] = $Type_compte;
if(isset($_POST['selectCompetence'])){
    $IdCompetenceChoisie=$_POST['selectCompetence'];
    $_SESSION['ID_Competence']=$IdCompetenceChoisie;
}
$reponseModifCompetenceProf = $_POST['modifCompetenceProf'];
$NomMatiere=$_SESSION['Nom_Matiere_Choisie'];
$_SESSION['Nom_Matiere_Choisie']=$NomMatiere;
require_once('../fonction.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Modifier une competence</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleToutesCompetences.css" rel="stylesheet" type="text/css">
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
                <div class="flexboxText-menu"><a href="toutesCompetencesPage.php" class="lienClique">Toutes les compétences</a></div>
                <?php } ?>
            <?php if($Type_compte=="Professeur"){ ?>
                <div class="flexboxText-menu"><a href="../evaluationsPage/evaluationsPage.php" class="lienWhite">Evaluations</a></div>
            <?php } ?>
            <?php if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section>
        <img src="../img/paris.jpg"  alt="parisCity" class="tailleImgFormualaire">
		<div class="formulaireModification">	
        <div class="login-form2">
        <form method="POST" action="modifMatiere.php">
            <?php
            if($reponseModifCompetenceProf=="Ajouter une compétence"){?>
                <h3>Ajouter une nouvelle compétence</h3>
                    Nom de la compétence : <input type="text" name="NewNom" placeholder="Entrez compétence"required><br><br>
                    Thème : <input type="text" name="NewTheme" placeholder="Entrez thème"><br><br>
                    Date de création : <input type="date" name="NewDate"><br><br>
                    <input type="submit" name="validerAjoutCompetenceProf" value="Enregistrer">
            <?php }?>
                </form>
            </div>
        </div>        
    </section>
</body>
</html>