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
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Toutes les compétences</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleToutesCompetences.css" rel="stylesheet" type="text/css">

</head>

<body>
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../mesMatieresPage/mesMatieresPage.html" class="lienWhite">Mes matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>

<section id="bodyToutesCompetencesPage">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formChoixTriCompetences">
        <input type="radio" name="choixTriCompetences" value="1" id="selectChoixTriCompetences">Ordre alphabétique croissant</option>
        <input type="radio" name="choixTriCompetences" value="2" id="selectChoixTriCompetences">Ordre alphabétique croissant</option>
        <input type="radio" name="choixTriCompetences" value="3" id="selectChoixTriCompetences">Statut</option>
        <input type="radio" name="choixTriCompetences" value="4" id="selectChoixTriCompetences">Date croissante</option>
        <input type="radio" name="choixTriCompetences" value="5" id="selectChoixTriCompetences">Date décroissante</option>
        <input type="radio" name="choixTriCompetences" value="6" id="selectChoixTriCompetences">Matières</option>
        <input type="radio" name="choixTriCompetences" value="7" id="selectChoixTriCompetences">Professeur</option>
</form>

<?php $_POST['choixTriCompetences']=6;
if(isset($_POST['choixTriCompetences'])){
    echo 'aaa';
}
if(!isset($_POST['choixTriCompetences'])){
    echo 'bb';
}?>
<?php if(isset($_POST['choixTriCompetences'])){
    switch($_POST['choixTriCompetences']) {
        case 1 : //ordre alphabétique compétences
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence
            WHERE competence.ID_Competence = compte_competence.ID_Competence
            AND compte_competence.ID_compte='$ID' 
            ORDER BY Nom ");
            break;
        case 2 : //ordre inalphabétique compétences
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence
            WHERE competence.ID_Competence = compte_competence.ID_Competence
            AND compte_competence.ID_compte='$ID' 
            ORDER BY Nom DESC");
            break;
        case 3 : //statut
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence
            WHERE competence.ID_Competence = compte_competence.ID_Competence
            AND compte_competence.ID_compte='$ID'
            ORDER BY Etat_competence");
            break;
        case 4 :
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence WHERE competence.ID_Competence = compte_competence.ID_Competence AND compte_competence.ID_compte='$ID' ORDER BY Date ASC");
            break;
        case 5 :
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence WHERE competence.ID_Competence = compte_competence.ID_Competence AND compte_competence.ID_compte='$ID' ORDER BY Date DESC");
            break;
        case 6 :
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence, matiere_competence, matiere 
            WHERE competence.ID_Competence = compte_competence.ID_Competence 
            AND compte_competence.ID_compte='$ID' 
            /*AND competence.ID_Competence = matiere_competence.ID_Competence*/
            ORDER BY matiere.Nom");
            break;
        case 7 :
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence WHERE competence.ID_Competence = compte_competence.ID_Competence AND compte_competence.ID_compte='$ID' ORDER BY Date DESC");
            break;
        default :
            $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence WHERE competence.ID_Competence = compte_competence.ID_Competence AND compte_competence.ID_compte='$ID'");
            break;
    }
} else {
    $reponseCompetence = $bdd->query("SELECT * FROM competence, compte_competence WHERE competence.ID_Competence = compte_competence.ID_Competence AND compte_competence.ID_compte='$ID'");
}
$reponseCompteCompetence = $bdd->query('SELECT * FROM compte_competence');?>
<table>
    <tr id="textLigne1">
        <td>Compétences</td>
        <td>Etat de la compétence</td>
    </tr>

<?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td class="textColonne"><?php echo $donneesCompetence['matiere.Nom']?></td>
        <td id="textColonne1"><?php echo $donneesCompetence['competence.Nom']?></td>
        <td class="textColonne"><?php echo $donneesCompetence['Etat_competence']?></td>
    </tr>
<?php } ?>
</table>
        
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>