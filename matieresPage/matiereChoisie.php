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
if(isset($_POST['Matiere'])){
    $Nom_Matiere_Choisie = $_POST['Matiere'];
}
if(isset($_POST['Matiere'])){
    $Nom_Matiere_Choisie = $_POST['Matiere'];
}
$_SESSION['Nom_Matiere_Choisie']=$Nom_Matiere_Choisie;

//SELECTION DES COMPETENCES EN FONCTION DE LA MATIERE
    if($Type_compte=="Administrateur"){
        $reponseCompetence = $bdd->query("SELECT * FROM matiere
            INNER JOIN matiere_competence ON matiere.ID_matiere = matiere_competence.ID_matiere
            INNER JOIN competence ON matiere_competence.ID_competence = competence.ID_competence
            WHERE Nom_matiere LIKE '$Nom_Matiere_Choisie'");
    }
    else if($Type_compte=="Professeur"){
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
                INNER JOIN compte_matiere ON compte.ID_Compte = compte_matiere.ID_Compte
                INNER JOIN matiere ON compte_matiere.ID_Matiere = matiere.ID_Matiere
                INNER JOIN matiere_competence ON matiere.ID_Matiere = matiere_competence.ID_Matiere
                INNER JOIN competence ON matiere_competence.ID_Competence = competence.ID_Competence
                WHERE compte.ID_Compte = '$ID'");
    }
    else {
        $reponseCompetence = $bdd->query("SELECT DISTINCT * FROM compte 
        INNER JOIN compte_competence ON compte.ID_Compte = compte_competence.ID_Compte
        INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence
        INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
        INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
        WHERE compte.ID_Compte = '$ID'
        AND matiere.Nom_Matiere = '$Nom_Matiere_Choisie'");
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
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
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
    <section id="competencesParMatiere">
<?php if($Type_compte!="Professeur"){ ?>
        <table>
        <tr id="textLigne1">
            <th>Compétences</th>
            <th>Matière</th>
            <?php if($Type_compte=="Etudiant"){?>
                <th>Etat de la compétence</th>
            <?php } ?>
        </tr>
    <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
        <tr>
            <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
            <td id="textColonne"><?php echo $donneesCompetence['Nom_matiere']?></td>
            <?php if($Type_compte=="Etudiant"){?>
                <td class="textColonne"><?php echo $donneesCompetence['Etat_competence']?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    </table>
    <div class="login-form3">
        <?php if($Type_compte=="Administrateur"){?>
                <form method="POST" action="modifMatiere.php"  id="formModifMatiere">
                    <input type="submit" name ="modifMatiere" value="Supprimer">
                    <input type="submit" name ="modifMatiere" value="Modifier">
                    <input type="submit" name ="modifMatiere" value="Ajouter un professeur">
                </form>
        <?php }
        if($Type_compte=="Etudiant"){?>
                <form method="POST" action="../autoEvaluation/autoevaluation.php" id="AutoEval">
                <input type="submit" name ="faireEval" value="Auto-évaluation">
                </form>
        <?php } ?>
    </div>        
<?php } else { //INTERFACE PROFESSEUR?>
    <table>
        <tr id="textLigne1">
            <th>Compétences</th>
            <th>Matière</th>
            <th>Sélection</th>
        </tr>
        <form method="POST" action="modifCompetenceProf.php">
        <?php while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
        <tr>
            <td id="textColonne1"><?php echo $donneesCompetence['Nom_competence']?></td>
            <td id="textColonne"><?php echo $donneesCompetence['Nom_matiere']?></td>
            <td id="textColonneSelection"> <input type="radio" name="selectCompetenceProf" value="<?php echo $donneesCompetence['ID_Competence']?>"></td>
        </tr>
        <?php } ?>
    </table>
    <div class="login-form3">
        <input type="submit" name ="modifCompetenceProf" value="Ajouter une compétence">
        <input type="submit" name ="modifCompetenceProf" value="Supprimer une compétence">
     </div>
     </form> 
<?php } ?>
</section>
    
<footer>
    <div class="floatLeft">Projet Développement Web</div>
    <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
</footer>

</body>

</html>