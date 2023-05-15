<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnes_my_skills; 
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

if(isset($_POST['validerSupression'])){
    //$tab_matiere = array('Nom_matiere' => $_POST['NewNom']);
    //$sql=("DELETE FROM matiere WHERE `matiere`.`Nom_matiere`='$_POST['NewNom']'");
    //$stmt = $PDO->prepare($sql);
    //$stmt->execute();
    supprimer($bdd, "matiere", "Nom_matiere=$nom");//Ca supprime passsssss
} 

if(isset($_POST['validerModification'])){
    //modifier fonction
}

if($Type_compte=="admin"){
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
            <div class="flexboxText-menu"><a href="matieresPage.php" class="lienClique">Matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="mesMatieres">
        <div class="flex-container-mesMatieres">
            <?php while($donneesMatiere = $reponseMatiere->fetch()) { ?>
                <div class="flexboxMatieres"><a href="matiereChoisie.php" class="lienWhite"><?php echo $donneesMatiere['Nom_matiere'] ?></a></div>
            <?php } ?>
        </div>
        </section>
        <?php if($Type_compte=="admin"){?>
            <form method="POST" action="modifMatiere.php" id="formModifMatiere">
                <input type="submit" name ="modifMatiere" value="Ajouter" class="boutonModif">
                <input type="submit" name ="modifMatiere" value="Supprimer" class="boutonModif">
                <input type="submit" name ="modifMatiere" value="Modifier" class="boutonModif">
            </form>
        <?php }?>
    
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>