<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Evaluations</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleEvaluationsPage.css" rel="stylesheet" type="text/css">

</head>

<body>
<?php

use function PHPSTORM_META\sql_injection_subst;

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
	header('Location: soumettre_noter.php');
	exit();
  }
$ID = $_SESSION['ID_Compte'];
$Type_compte = $_SESSION['Type_compte'];
$ID_Matiere = $_SESSION['ID_Matiere'];
$ID_Ecole = $_SESSION['ID_Ecole'];
$etudiant = $_SESSION['etudiant'];
$promo = $_SESSION['promo'];
$classe = $_SESSION['classe'];
$_SESSION['ID_Compte'] = $ID;
$_SESSION['Type_compte'] = $Type_compte;
$_SESSION['ID_Matiere'] = $ID_Matiere;
$_SESSION['ID_Ecole'] = $ID_Ecole;
$_SESSION['etudiant'] = $etudiant;
$_SESSION['promo'] = $promo;
$_SESSION['classe'] = $classe;

?>

     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
                <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
                <?php }
            if($Type_compte=="Professeur"){ ?>
                <div class="flexboxText-menu"><a href="evaluationsPage.php" class="lienClique">Evaluations</a></div>
            <?php }
            if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>



    <?php
$reponseetu = $bdd->query('SELECT * FROM compte');
?><div class="login-form3">
    <section id="titre">
        <h7>Appréciation : <br></h7>
       <?php 
while ($donneesetu = $reponseetu->fetch()){
    if ($donneesetu['ID_Compte'] == $etudiant) {
        echo "Vous regardez le compte de l'étudiant : ".$donneesetu['Nom']." ".$donneesetu['Prenom']."";
    }
}
?><table>
    <tr id="textLigne1">
        <th>Compétence</th>
        <th>Thème</th>
        <th>Date de création</th>
    </tr>
    <?php
    if ($Type_compte=='Professeur'){
    $reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_competence ON Compte.ID_compte = compte_competence.ID_compte INNER JOIN competence ON compte_competence.ID_competence = competence.ID_competence INNER JOIN matiere_competence ON competence.ID_competence = matiere_competence.ID_Competence INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere');
    while ($donnees = $reponse->fetch()){
        if ($donnees['ID_Compte'] == $etudiant && $donnees['ID_Matiere']==$ID_Matiere ) { ?>
            <tr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <td><?php echo $donnees['Nom_competence' ]."  Note de l'etudiant : ".$donnees['Etat_competence'] . ".            Appreciation :";
                $idcompet =$donnees['ID_compte_competence']; ?></td>
                <td> <input type="text" name=" <?php echo $idcompet; ?>"></td>
                <br><br>
        <?php
        }
    }?>
    </table>
        <input type="submit" name="submit" value="Valider">
</form>
<?php
if (isset($_POST['submit'])) {
    foreach ($_POST as $idcompet => $value) {
        if ($idcompet != "submit") {
            if ($value!=""){
            $sql ="UPDATE compte_competence SET Appreciation='$value' WHERE ID_Compte = '$etudiant' AND ID_compte_competence = '$idcompet'";
            $bdd -> query($sql);
            $sql ="UPDATE compte_competence SET Competence_valide_Professeur='valide' WHERE ID_Compte = '$etudiant' AND ID_compte_competence = '$idcompet'";
            $bdd -> query($sql);
        }
    }
}
}
}
?>
  <br> <br>
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
    <br> <br>
</section>
</div>
</body>
</html>