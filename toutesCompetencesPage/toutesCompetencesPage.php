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
require_once('../fonction.php');
$ID = $_SESSION['ID_Compte'];
$Type_compte = $_SESSION['Type_compte'];
$_SESSION['ID_Compte'] = $ID;
$_SESSION['Type_compte'] = $Type_compte;
if(isset($_SESSION['ID_Competence'])){
    $recup_ID_Competence=$_SESSION['ID_Competence'];
}
if (isset($_POST['selectCompetence'])) {
    $competenceId = $_POST['selectCompetence'];
}
if (isset($_POST['selectCompetenceEtudiant'])) {
    $competenceId2 = $_POST['selectCompetenceEtudiant'];
}
//SELECTIONNER LES COMPETENCES QUI APPARTIENNENT AU COMPTE
 $reponseCompetenceQuiMappartient = $bdd->query("SELECT DISTINCT * FROM competence
        INNER JOIN compte_competence ON competence.ID_Competence = compte_competence.ID_Competence
        INNER JOIN compte ON compte_competence.ID_Compte = compte.ID_Compte
        WHERE compte.ID_Compte = $ID");
$i=0;
while($donneesCompetenceQuiMappartient = $reponseCompetenceQuiMappartient->fetch()){
    $tab_Competence_Appartient[$i] = $donneesCompetenceQuiMappartient['ID_Competence'];
    $i++;
}


//CREER UNE COMPETENCE
if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_Competence" => NULL,
        "Nom_competence" => $_POST['NewNom'],
        "Date_Creation" => $_POST['NewDate'],
        "Theme" => $_POST['NewTheme']
    ];
    insertion($bdd,"competence", $tab_matiere);
}
//MODIFIER UNE COMPETENCE
if(isset($_POST['validerModification'])){
    if ($_POST['NewNom']){
        $newNom = $_POST['NewNom'];
        echo $newNom;
        $sql = "UPDATE competence SET Nom_competence = '$newNom' WHERE ID_Competence = '$recup_ID_Competence'";
        $bdd->query($sql);
    }
    
    if ($_POST['NewTheme'] != ''){
        $newTheme = $_POST['NewTheme'];
        echo $newTheme;
        $sql = "UPDATE competence SET Theme = '$newTheme' WHERE ID_Competence = '$recup_ID_Competence'";
        $bdd->query($sql);
    }
    if ($_POST['NewDate'] != ''){
        $newDate = $_POST['NewDate'];
        echo $newDate;
        $sql = "UPDATE competence SET Date_Creation = '$newDate' WHERE ID_Competence = '$recup_ID_Competence'";
        $bdd->query($sql);
    }
}
//SUPPRIMER UNE COMPETENCE
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
//S'AJOUTER UNE COMPETENCE
if(isset($_POST['selectCompetenceEtudiant'])){
    $tab_compte_competence = [
        "ID_compte_competence" => NULL,
        "ID_Compte" => $ID,
        "ID_Competence" => $_POST['selectCompetenceEtudiant'],
        "Moyenne_professeur" => NULL,
        "Etat_competence" => 'Non Evalue',
        "Competence_valide_etudiant" => 'Non Evalue',
        "Competence_valide_professeur" => 'Non Evalue',
        "Appreciation" => 'Aucune'
    ];
    insertion($bdd,"compte_competence", $tab_compte_competence);
    header("Location: ".$_SERVER['PHP_SELF']);
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

<?php //TRI DES COMPETENCES
if(isset($_POST['choixTriCompetences'])){
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
            $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence
            WHERE competence.ID_Competence NOT IN (
            SELECT compte_competence.ID_Competence 
            FROM compte_competence 
            INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence 
            WHERE compte_competence.ID_Compte = $ID)");
            break;
        default :
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence");
            break;
    }
} else {
    $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM competence");
}
if($Type_compte=="Etudiant"){ //AFFICHAGE DE L'INTERFACE ETUDIANTE ?>
<table>
    <tr id="textLigne1">
        <th>Compétence</th>
        <th>Thème</th>
        <th>Date de création</th>
        <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant") { ?>
        <th>Sélection</th>
        <?php } ?>
    </tr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formCompetencesEtudiant">
        <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Theme']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Date_Creation']?></td>
        
        <?php if (in_array($donneesCompetence['ID_Competence'], $tab_Competence_Appartient)) { ?>
        <td id="textColonneSelection">
            <img src="../img/check.png" alt="check" class="imageCheck">
        </td>
        <?php } else { ?>
        <td id="textColonneSelection">
            <input type="radio" name="selectCompetenceEtudiant" value="<?php echo $donneesCompetence['ID_Competence']?>" onchange="document.getElementById('formCompetencesEtudiant').submit()">
        </td>  
        <?php } ?>    
    </tr>
    <?php } ?>
    </form>
</table>
<?php } else { //AFFICHAGE DE L'INTERFACE DES AUTRES UTILISATEURS (ADMIN)?>
<table>
    <tr id="textLigne1">
        <th>Compétence</th>
        <th>Thème</th>
        <th>Date de création</th>
        <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant") { ?>
        <th>Sélection</th>
        <?php } ?>
    </tr>
    <form method="POST" action="modifCompetence.php">
        <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Theme']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Date_Creation']?></td>
        <?php if($Type_compte=="Administrateur") { ?>
            <td id="textColonneSelection"> <input type="radio" name="selectCompetence" value="<?php echo $donneesCompetence['ID_Competence']?>"></td>
        <?php }?>        
    </tr>
    <?php } ?>
</table>
<?php }
if($Type_compte=="Administrateur"){?>
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