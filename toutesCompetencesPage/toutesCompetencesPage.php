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
if(isset($_SESSION['ID_Competence'])){
    $recup_ID_Competence=$_SESSION['ID_Competence'];
}
require_once('../fonction.php');

if (isset($_POST['selectCompetence'])) {
    $competenceId = $_POST['selectCompetence'];
    echo $competenceId;
}

if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_Competence" => NULL,
        "Nom_competence" => $_POST['NewNom'],
        "Date_Creation" => $_POST['NewDate'],
        "Theme" => $_POST['NewTheme']
    ];
    insertion($bdd,"competence", $tab_matiere);
}
/*
if(isset($_POST['validerModification'])){
    if($_POST['NewNom']!=''){
        $NewNom=$_POST['NewNom'];
        $modificationMatiere = "UPDATE matiere SET Nom_matiere = '$NewNom' WHERE Nom_matiere='$NomMatiere'";
		$bdd->query($modificationMatiere);
    }
    if($_POST['NewVolumeHoraire']!=''){
        $NewVolumeHoraire=$_POST['NewVolumeHoraire'];
        $modificationMatiere = "UPDATE matiere SET Volume_horaire = '$NewVolumeHoraire' WHERE Nom_matiere='$NomMatiere'";
		$bdd->query($modificationMatiere); 
    }
}*/
if(isset($_POST['validerSuppression'])){
    if($_POST['validerSuppression']=="Valider"){
        $sql1="DELETE FROM compte_competence WHERE ID_Competence=$recup_ID_Competence";
        $sql2="DELETE FROM matiere_competence WHERE matiere_competence.ID_Competence=$recup_ID_Competence";
        $sql3="DELETE FROM competence WHERE ID_Competence=$recup_ID_Competence";
        $stmt1=$bdd->prepare($sql1);
        $stmt2=$bdd->prepare($sql2);
        $stmt3=$bdd->prepare($sql3);
        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
    }
}
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
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.php" class="lienWhite">Compétences transverses</a></div>
                <div class="flexboxText-menu"><a href="toutesCompetencesPage.php" class="lienClique">Toutes les compétences</a></div>
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

    <section id="bodyToutesCompetencesPage">
    <div class="login-form3">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="formChoixTri">
            <input type="radio" name="choixTriCompetences" value="1" class="selectChoixTri">Ordre alphabétique croissant</option>
            <input type="radio" name="choixTriCompetences" value="2" class="selectChoixTri">Ordre alphabétique décroissant</option>
            <input type="radio" name="choixTriCompetences" value="3" class="selectChoixTri">Thème</option>
            <input type="radio" name="choixTriCompetences" value="4" class="selectChoixTri">Date croissante</option>
            <input type="radio" name="choixTriCompetences" value="5" class="selectChoixTri">Date décroissante</option>
            <?php if($Type_compte == "Etudiant") { ?>
                <input type="radio" name="choixTriCompetences" value="6" class="selectChoixTri">Non ajoutée</option>
            <?php } ?>
            <input type="submit" value="valider">
        </form>
    </div>    

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
        case 6 : //compétence que je n'ai pas
            $reponseCompetence = "SELECT DISTINCT competence.Nom_competence, competence.ID_Competence FROM competence
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            WHERE Nom_matiere = $Matiere AND competence.ID_Competence NOT IN (
            SELECT compte_competence.ID_Competence 
            FROM compte_competence 
            INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence 
            WHERE compte_competence.ID_Compte = '$ID')";
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
        <th>Compétence</th>
        <th>Thème</th>
        <th>Date de création</th>
        <th>Sélection</th>
    </tr>
    <form method="POST" action="modifCompetence.php">
        <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Theme']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Date_Creation']?></td>
        <?php if($Type_compte=="Administrateur" || $Type_compte=="Professeur") { ?>
            <td id="textColonneSelection"> <input type="radio" name="selectCompetence" value="<?php echo $donneesCompetence['ID_Competence']?>"></td>
        <?php }
        
        /*if($Type_compte=="Etudiant"){ 
            if(){ ?>
                <td><button onclick="ajouterMesCompetence()">Ajouter</button></td>
            <?php }else{ ?>
            <?php }
        } */?>
        
    </tr>
    <?php } ?>
</table>
<?php if($Type_compte=="Administrateur"){?>
    <div class="login-form3">
            <input type="submit" name ="modifCompetence" value="Ajouter">
            <input type="submit" name ="modifCompetence" value="Supprimer">
            <input type="submit" name ="modifCompetence" value="Modifier">
        </form>
    </div>
<?php }?>
</section>  
<footer>
    <div class="floatLeft">Projet Développement Web</div>
    <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
</footer>
</body>

</html>