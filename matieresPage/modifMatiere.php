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
$Nom_Matiere_Choisie = $_SESSION['Nom_Matiere_Choisie'];
require_once('../fonction.php');

$reponseModifMatiere = $_POST['modifMatiere'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Modifier une matière</title>
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
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
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
    <section>
        <img src="../img/paris.jpg"  alt="parisCity" class="tailleImgFormualaire">
        <div class="formulaireModification">	   
            <div class="login-form2">
            <form method="POST" action="matieresPage.php">
            <?php if($reponseModifMatiere=="Ajouter"){?>
				<h3>Ajouter une nouvelle matière</h3>
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"required><br><br>
                    Volume horaire : <input type="number" name="NewVolumeHoraire" placeholder="Entrez volume horaire"required min="0"><br><br>
                    <input type="submit" name="validerAjout" value="Enregistrer">
                    <?php }
                if($reponseModifMatiere=="Supprimer"){ ?>
                    <h3>Etes vous sur de vouloir supprimer la matière <?php echo $Nom_Matiere_Choisie ?> ?</h3>
                    <input type="submit" name="validerSuppression" value="Valider">
                    <input type="submit" name="validerSuppression" value="Annuler">
                <?php }
                if($reponseModifMatiere=="Modifier"){?>
                    <h3>Modifier une matière</h3>
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"><br><br>
                    Volume horaire : <input type="number" name="NewVolumeHoraire" placeholder="Entrez nouveau volume horaire" min="0"><br><br>
                    <input type="submit" name="validerModification" value="Enregistrer">
                    <?php }
                if($reponseModifMatiere=="Ajouter un professeur"){?>
                    <h3>Sélectionner le professeur à ajouter à la matière <?php echo $Nom_Matiere_Choisie ?></h3>
                    <?php $reponseProfesseurs=$bdd->query("SELECT * FROM compte WHERE Type_compte='Professeur'");
                    while ($donneesProfesseurs = $reponseProfesseurs->fetch()){ ?>
                        <label>
                        <input type="radio" name="professeurSelect" value="<?php echo $donneesProfesseurs['Nom']?>">
                        <span style="font-family: openSansLight;"><?php echo $donneesProfesseurs['Nom']?></span>
                        </label>
                 <?php } ?>
                 <br>
                 <input type="submit" name="validerAjoutProf" value="Enregistrer">
                        <input type="radio" name="professeurSelect" value="<?php echo $donneesProfesseurs['ID_Compte']?>"><?php echo $donneesProfesseurs['Nom']?><br>
                    <?php } ?>
                    <input type="submit" name="validerAjoutProf" value="Enregistrer">
                    <input type="submit" name="validerAjoutProf" value="Annuler">
                 <?php } ?>
                </form>
            </div>
        </div>
    </section>
    <footer>
    	<div class="floatLeft">Projet Développement Web</div>
    	<div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>
</html>