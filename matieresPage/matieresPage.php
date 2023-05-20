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

if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_matiere" => NULL,
        "Nom_matiere" => $_POST['NewNom'],
        "Volume_horaire" => $_POST['NewVolumeHoraire']
    ];
    insertion($bdd,"matiere", $tab_matiere);
}

if(isset($_POST['validerModification'])){
    //modifier fonction
}

if($Type_compte=="Administrateur"){
    $reponseMatiere = $bdd->query("SELECT Nom_matiere FROM matiere" /*"SELECT * FROM matiere
    INNER JOIN matiere_competence ON matiere.ID_matiere = matiere_competence.ID_matiere
INNER JOIN competence ON matiere_competence.ID_competence = competence.ID_competence"*/ );
} else {
    $reponseMatiere = $bdd->query("SELECT Nom_matiere FROM matiere 
        INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
        INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
        WHERE compte.ID_Compte = '$ID'"
        /*"SELECT * FROM competence 
        INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
        INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
        INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
        INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
        INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
        WHERE compte_competence.ID_Compte = '$ID'
        GROUP BY Nom_matiere"*/);
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
    <section id="bodyMesMatieres">
        <!--<div class="flex-container-mesMatieres">-->
        <form method="POST" action="matiereChoisie.php">
            <?php while($donneesMatiere = $reponseMatiere->fetch()) {  ?>
                <input type="submit" name ="Matiere" value= <?php echo $donneesMatiere['Nom_matiere'];?> class="boutonMatiere">
                <?php } ?>
        </form>
        <!--</div>-->
        </section>
        <?php if($Type_compte=="Administrateur"){?>
            <div class="login-form3">
                <form method="POST" action="modifMatiere.php" id="formModifMatiere">
                    <input type="submit" name ="modifMatiere" value="Ajouter" class="boutonModif">
                </form>
            </div>
        <?php }?>



        <?php if($Type_compte=="Prof"){?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="boutonModif">
            <?php echo "soumettre une auto-evaluation" ?>
            <input type="submit" name ="soumettreEval" value="soumettre une auto evaluation" class="boutonAutoEval">
            </form>
            <?php }?>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['soumettreEval']=="soumettre"){
                //code sql qui notif l'eleve
            }
        }
?>


    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>