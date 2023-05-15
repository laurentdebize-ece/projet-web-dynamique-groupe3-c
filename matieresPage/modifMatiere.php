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
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <?php if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="bodyModifMatiere">
        <?php if($reponseModifMatiere=="Ajouter"){ //Style a faire emma?>
        <div id="formulaireMofifMatiere">	   
            <div class="login-form2">
				<h3>Ajouter une nouvelle matière</h3>
                <form method="POST" action="matieresPage.php" id="ajouterMatiere">
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"required><br><br>
                    Volume horaire : <input type="text" name="NewVolumeHoraire" placeholder="Entrez volume horaire"required min="0"><br><br>
                    <input type="submit" name="validerAjout" value="Enregistrer">
                </form>
            </div>
        </div>        
        <?php }

        if($reponseModifMatiere=="Supprimer"){//Style a faire emma?>
        <div id="formulaireMofifMatiere">    
            <div class="login-form2">
				<h3>Supprimer une matière</h3>
                <form method="POST" action="matieresPage.php" id="supprimerMatiere">
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"required><br><br>
                    <input type="submit" name="validerSuppression" value="Enregistrer">
                </form>
            </div>
        </div>    
        <?php }

        if($reponseModifMatiere=="Modifier"){//Style a faire emma?>
        <div id="formulaireMofifMatiere"> 
            <div class="login-form2">
				<h3>Supprimer une matière</h3>
                <form method="POST" action="matieresPage.php" id="modifierMatiere">
                    Nom de la matière : <input type="text" name="NewNom" placeholder="Entrez matière"required><br><br>
                    Volume horaire : <input type="text" name="NewVolumeHoraire" placeholder="Entrez nouveau volume horaire"required min="0"><br><br>
                    <input type="submit" name="validerModofication" value="Enregistrer">
                </form>
            </div>
        </div>
        <?php }?>
    </section>
</body>
</html>