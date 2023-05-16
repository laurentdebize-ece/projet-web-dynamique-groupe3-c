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

/*if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_Competence" => NULL,
        "Nom_competence" => $_POST['NewNom'],
        "Date_Creation" => $_POST['NewDate'],
        "Theme" => $_POST['NewTheme']
    ];
    insertion($bdd,"competence", $tab_matiere);
}

if(isset($_POST['validerSupression'])){
    //$tab_matiere = array('Nom_matiere' => $_POST['NewNom']);
    //$sql=("DELETE FROM matiere WHERE `matiere`.`Nom_matiere`='$_POST['NewNom']'");
    //$stmt = $PDO->prepare($sql);
    //$stmt->execute();
    //supprimer($bdd, "competence", "Nom_matiere=$nom");//Ca supprime passsssss
} 

if(isset($_POST['validerModification'])){
    //modifier fonction
}
*/
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

    <section id="bodyToutesCompetencesPage">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formChoixTriCompetences">
        <input type="radio" name="choixTriCompetences" value="1" id="selectChoixTriCompetences">Ordre alphabétique croissant</option>
        <input type="radio" name="choixTriCompetences" value="2" id="selectChoixTriCompetences">Ordre alphabétique décroissant</option>
        <input type="radio" name="choixTriCompetences" value="3" id="selectChoixTriCompetences">Thème</option>
        <input type="radio" name="choixTriCompetences" value="4" id="selectChoixTriCompetences">Date croissante</option>
        <input type="radio" name="choixTriCompetences" value="5" id="selectChoixTriCompetences">Date décroissante</option>
        <input type="submit" value="valider">
</form>

<?php if(isset($_POST['choixTriCompetences'])){
    switch($_POST['choixTriCompetences']) {
        case 1 : //ordre alphabétique compétences
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence ORDER BY Nom_competence");
            break;
        case 2 : //ordre inalphabétique compétences
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence ORDER BY Nom_competence DESC");
            break;
        case 3 : //thème
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence ORDER BY Theme");
            break;
        case 4 : //date par ordre croissant
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence ORDER BY Date_Creation ASC");
            break;
        case 5 : //date par ordre décroissant
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence ORDER BY Date_Creation DESC");
            break;
        default :
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence");
            break;
    }
} else {
    $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence");
}?>
<table>
    <tr id="textLigne1">
        <td>Compétence</td>
        <td>Thème</td>
        <td>Date de création</td>
    </tr>
<?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Theme']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Date_Creation']?></td>
        <td>
            <button onclick="supprimerMesCompetence()">Supprimer</button>
        </td>
        <td>
            <button onclick="ajouterMesCompetence()">Ajouter</button>
        </td>
    </tr>
<?php } ?>
</table>
<?php if($Type_compte=="Administrateur"){?>
            <form method="POST" action="modifCompetence.php" id="formModifCompetence">
                <input type="submit" name ="modifCompetence" value="Ajouter" class="boutonModif">
                <input type="submit" name ="modifCompetence" value="Supprimer" class="boutonModif">
                <input type="submit" name ="modifCompetence" value="Modifier" class="boutonModif">
            </form>
        <?php }?>
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>