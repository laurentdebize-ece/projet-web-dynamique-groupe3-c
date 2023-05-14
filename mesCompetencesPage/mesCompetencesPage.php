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
    <title>OMNES MySkills - Mes compétences</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleMesCompetences.css" rel="stylesheet" type="text/css">

</head>

<body>
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <div class="flexboxText-menu"><a href="mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>

<section id="bodyMesCompetencesPage">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formChoixTriCompetences">
        <input type="radio" name="choixTriCompetences" value="1" id="selectChoixTriCompetences">Ordre alphabétique croissant</option>
        <input type="radio" name="choixTriCompetences" value="2" id="selectChoixTriCompetences">Ordre alphabétique croissant</option>
        <input type="radio" name="choixTriCompetences" value="3" id="selectChoixTriCompetences">Statut</option>
        <input type="radio" name="choixTriCompetences" value="4" id="selectChoixTriCompetences">Date croissante</option>
        <input type="radio" name="choixTriCompetences" value="5" id="selectChoixTriCompetences">Date décroissante</option>
        <input type="radio" name="choixTriCompetences" value="6" id="selectChoixTriCompetences">Matières</option>
        <input type="radio" name="choixTriCompetences" value="7" id="selectChoixTriCompetences">Professeur</option>
        <input type="submit" value="valider">
</form>

<?php
if(isset($_POST['choixTriCompetences'])){
    echo 'pasnull';
}
if(!isset($_POST['choixTriCompetences'])){
    echo 'null';
}?>
<?php if(isset($_POST['choixTriCompetences'])){
    switch($_POST['choixTriCompetences']) {
        case 1 : //ordre alphabétique compétences
            $reponseCompetence = $bdd->query(" SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte.ID_Compte = '$ID'
            ORDER BY Nom_competence ");
            break;
        case 2 : //ordre inalphabétique compétences
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '$ID' 
            ORDER BY Nom_competence DESC");
            break;
        case 3 : //statut
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '$ID'
            ORDER BY Etat_competence");
            break;
        case 4 : //date par ordre croissant
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '$ID'
            ORDER BY Date ASC");
            break;
        case 5 : //date par ordre décroissant
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '$ID'
            ORDER BY Date DESC");
            break;
        case 6 : //matiere
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte.ID_Compte = '$ID'
            ORDER BY matiere.Nom_matiere");
            break;
        case 7 : //professseur
            $reponseCompetence = $bdd->query("SELECT * FROM competence 
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            INNER JOIN compte_matiere ON matiere.ID_Matiere = compte_matiere.ID_Matiere
            INNER JOIN compte ON compte_matiere.ID_Compte = compte.ID_Compte
            INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
            WHERE compte_competence.ID_Compte = '$ID'
            ORDER BY matiere_competence.professeur");
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
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Nom_matiere']?></td>
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
