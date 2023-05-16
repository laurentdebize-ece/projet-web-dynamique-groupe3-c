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

$reponseModifCompetence = $_POST['modifCompetence'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Modifier une competence</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleMatieres.css" rel="stylesheet" type="text/css">
</head>

<body>
<section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php } ?>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
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
    <section id="bodyModifCompetence">
        <?php if($reponseModifCompetence=="Ajouter"){ //Style a faire emma?>
        <div id="formulaireMofifCompetence">	   
            <div class="login-form2">
				<h3>Ajouter une nouvelle compétence</h3>
                <form method="POST" action="toutesCompetencesPage.php" id="ajouterCompetence">
                    Nom de la compétence : <input type="text" name="NewNom" placeholder="Entrez compétence"required><br><br>
                    Thème : <input type="text" name="NewTheme" placeholder="Entrez thème"><br><br>
                    Date de création : <input type="date" name="NewDate"><br><br>
                    <input type="submit" name="validerAjout" value="Enregistrer">
                </form>
            </div>
        </div>        
        <?php }

        if($reponseModifCompetence=="Supprimer"){//Style a faire emma?>
        <div id="formulaireMofifCompetence">    
            <div class="login-form2">
				<h3>Supprimer une compétence</h3>
                <form method="POST" action="toutesCompetencesPage.php" id="supprimerCompetence">
                    Nom de la compétence : <input type="text" name="NewNom" placeholder="Entrez compétence"required><br><br>
                    Thème : <input type="text" name="NewTheme" placeholder="Entrez thème"><br><br>
                    <input type="submit" name="validerSuppression" value="Enregistrer">
                </form>
            </div>
        </div>    
        <?php }

        if($reponseModifCompetence=="Modifier"){//Style a faire emma?>
        <div id="formulaireMofifCompetence"> 
            <div class="login-form2">
				<h3>Modifier une compétence</h3>
                <form method="POST" action="toutesCompetencesPage.php" id="modifierCompetence">
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"required><br><br>
                    Thème : <input type="text" name="NewTheme" placeholder="Entrez thème"><br><br>
                    Date de création : <input type="date" name="NewDate"><br><br>
                    <input type="submit" name="validerModofication" value="Enregistrer">
                </form>
            </div>
        </div>
        <?php }?>
    </section>
</body>
</html>