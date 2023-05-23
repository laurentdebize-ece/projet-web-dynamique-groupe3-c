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
require_once('../fonction.php');
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
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.php" class="lienWhite">Compétences transverses</a></div>
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
//TRI DES COMPETENCES
<section id="bodyMesCompetencesPage">
    <div class="login-form3">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="formChoixTri">
                <input type="radio" name="choixTriCompetences" value="1" class="selectChoixTri">Ordre alphabétique croissant</option>
                <input type="radio" name="choixTriCompetences" value="2" class="selectChoixTri">Ordre alphabétique décroissant</option>
                <input type="radio" name="choixTriCompetences" value="3" class="selectChoixTri">Statut</option>
                <input type="radio" name="choixTriCompetences" value="4" class="selectChoixTri">Date croissante</option>
                <input type="radio" name="choixTriCompetences" value="5" class="selectChoixTri">Date décroissante</option>
                <input type="radio" name="choixTriCompetences" value="6" class="selectChoixTri">Matières</option>
                <input type="radio" name="choixTriCompetences" value="7" class="selectChoixTri">Professeur</option>
                <input type="submit" value="valider">
        </form>
    </div>
<?php if(isset($_POST['choixTriCompetences'])){
        switch($_POST['choixTriCompetences']) {
            case 1 : //ordre alphabétique compétences
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY Nom_competence ");
                break;
            case 2 : //ordre inalphabétique compétences
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY Nom_competence DESC");
                break;
            case 3 : //statut
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY Etat_competence");
                break;
            case 4 : //date par ordre croissant
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY Date_Creation ASC");
                break;
            case 5 : //date par ordre décroissant
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY Date_Creation DESC");
                break;
            case 6 : //matiere
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY matiere.Nom_matiere");
                break;
            case 7 : //professseur
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID'
                ORDER BY matiere_competence.professeur");
                break;
            default :
                $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
                INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
                INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
                INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
                WHERE compte.ID_Compte = '$ID' ");
                break;
        }
    } else {
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
        INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
        INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
        INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
        INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
        WHERE compte.ID_Compte = '$ID' ");
}?>
//AFFICHAGE DES COMPETENCES
<table>
    <tr id="textLigne1">
        <th>Compétences</th>
        <th>Thème</th>
        <th>Date de création</th>
        <th>Professeur</th>
        <th>Matière</th>
    </tr>
<?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Theme']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Date_Creation']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Professeur']?></td>
        <td id="textColonne"><?php echo $donneesCompetence['Nom_matiere']?></td>
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