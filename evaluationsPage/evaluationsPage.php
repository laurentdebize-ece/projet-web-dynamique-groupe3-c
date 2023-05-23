<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Evaluations</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleEvaluationsPage.css" rel="stylesheet" type="text/css">

</head>

<body>
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
?>
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
                <div class="flexboxText-menu"><a href="evaluationsPage.php" class="lienClique">Evaluations</a></div>
            <?php }
            if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>

<?php
$reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_matiere ON compte.ID_Compte= compte_matiere.ID_Compte');

while ($donnees = $reponse->fetch()){
	if ($donnees['ID_Compte'] == $ID) {
    $ID_Ecole=$donnees['ID_Ecole'];
    $ID_Matiere=$donnees['ID_Matiere'];
    }
}

if ($Type_compte == "Professeur") {?>
<img src="../img/nyCity.jpg"  alt=" nyCity " id="tailleImgEval"><!--https://www.artheroes.fr/-->
<section id="bodyEvaluationsPage">
<div id="zoneBoutonsEval">
//EVALUATION DES ELEVES PAR LE PROF
if ($Type_compte == "Professeur") {
    ?>
    <br> <br><br><br>
 <div class="login-form3">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="submit" name="valideaction" value="Evaluation" class="boutonEval"><br>
        <input type="submit" name="valideaction" value="Auto Evaluation" class="boutonEval">
    </form>
</div>
    <?php
    if (isset($_POST['valideaction'])) {
				session_start();
				$_SESSION['ID_Compte'] = $ID;
				$_SESSION['Type_compte'] = $Type_compte;
                $_SESSION['action'] = $_POST['valideaction'];
				header('Location: soumettre_noter.php');
				exit();
        }?>
        </section>
    <?php }
    ?>

<footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
    <br> <br>
</body>

</html>