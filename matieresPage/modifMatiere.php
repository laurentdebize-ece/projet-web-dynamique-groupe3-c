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
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienWhite">Matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section class="aaa">
        <?php if(isset($reponseAjoutMatiere)){ ?>
            <p>pas nul</p>
        <?php } 
        if(!isset($reponseAjoutMatiere)){ ?>
            <p>nul</p>
        <?php }
        if($reponseModifMatiere=="Ajouter"){ ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="ajouterMatiere">
                Nom de la matière : <input type="text" name="NewNom"><br>
                Volume horaire : <input type="number" name="NewVolumeHoraire"><br>
                <input type="button" name="valider" value="Enregistrer">
            </form>
            <?php 
            if($_SERVER["REQUEST_METHOD"]=="POST"){
            if($_POST['NewNom']==''){
                echo'vide';
            }
            if($_POST['NewNom']!=''){
                echo'non vide';
            }
                if(isset($_POST['valider'])){
                    ajouter($bdd, 'matiere', 'Nom_matiere', $_POST['NewNom']);
                    ajouter($bdd, 'matiere', 'Volume_horaire', $_POST['NewVolumeHoraire']);
                    header('location: matieresPage.php');
                    exit();
                }
            }
            
            
         }else{echo"noooooooooooooooooo";} ?>
    </section>
</body>
</html>