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
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <?php if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php }
            if($Type_compte=="Professeur" || $Type_compte=="Etudiant"){ ?>
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
    
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
    <br> <br><br> <br>



<?php
$reponse = $bdd->query('SELECT * FROM compte INNER JOIN compte_matiere ON compte.ID_Compte= compte_matiere.ID_Compte');

while ($donnees = $reponse->fetch()){
	if ($donnees['ID_Compte'] == $ID) {
    $ID_Ecole=$donnees['ID_Ecole'];
    $ID_Matiere=$donnees['ID_Matiere'];
    }
}

if ($Type_compte=="Professeur") {
    $reponse4 = $bdd->query('SELECT * FROM promotion');
    ?>
    <br> <br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        promo :
        
        <select name="choixPromo" id="choix">
            <?php
            while ($donnees4 = $reponse4->fetch()){ 
                if ($donnees4['ID_Ecole'] == $ID_Ecole) {
                    ?>
                    <option value="<?php echo $donnees4['ID_Promotion'];?>"><?php echo $donnees4['Anne_fin'];?> </option>
                <?php 
                }
            } ?>
        </select>
        <input type="submit" name="validechoixpromo" value="choisir">
    </form>

    <?php
    if (isset($_POST['validechoixpromo'])) {
        if (isset($_POST['choixPromo'])) {
            echo 'classe :';
            $choixPromo = $_POST['choixPromo'];
            echo $choixPromo;
            $reponse5 = $bdd->prepare('SELECT * FROM classe INNER JOIN promotion ON classe.ID_Promotion = promotion.ID_Promotion WHERE promotion.ID_Promotion = :promo');
            $reponse5->bindParam(':promo', $choixPromo);
            $reponse5->execute();
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <select name="choixClasse" id="choix">
                    <?php while ($donnees5 = $reponse5->fetch()){ 
                        if ($donnees5['ID_Promotion'] == $choixPromo) {
                            ?>
                            <option value="<?php echo $donnees5['ID_Classe'];?>"><?php echo $donnees5['Num_groupe'];?> </option>
                        <?php 
                        }
                    } ?>
                </select>
                <input type="hidden" name="choixPromo" value="<?php echo $choixPromo; ?>">
                <input type="submit" name="soumettre_evaluation" value="Soumettre">
            </form>
        <?php
        }
    }
}

if (isset($_POST['soumettre_evaluation'])) {
    if (isset($_POST['choixPromo']) && isset($_POST['choixClasse'])) {
        $choixPromo = $_POST['choixPromo'];
        $choixClasse = $_POST['choixClasse'];
        echo "ID Promo choisie : $choixPromo<br>";
        echo "ID Classe choisie : $choixClasse<br>";
        echo "ID matiere : $ID_Matiere<br>";
        echo "Auto evaluation soumise aux etudiants <br>";

        
        $reponse3 = $bdd->query('SELECT * FROM promotion INNER JOIN compte ON promotion.ID_Ecole=compte.ID_Ecole AND promotion.ID_Promotion= compte.ID_Promotion 
        INNER JOIN compte_matiere ON compte.ID_compte=compte_matiere.ID_Compte 
        INNER JOIN matiere_competence ON compte_matiere.ID_Matiere=matiere_competence.ID_Matiere 
        INNER JOIN competence ON matiere_competence.ID_Competence=competence.ID_Competence
        INNER JOIN compte_competence ON compte.ID_Compte=compte_competence.ID_Compte AND competence.ID_competence=compte_competence.ID_competence');
        while ($donnees3 = $reponse3->fetch()){
            if ($donnees3['ID_Ecole'] == $ID_Ecole && $donnees3['ID_Matiere']==$ID_Matiere && $donnees3['Type_compte']!='professeur ' && $donnees3['ID_Promotion']==$choixPromo && $donnees3['ID_Classe']== $choixClasse) {
                $ID_Compte_soumettre = $donnees3['ID_Compte'];


                if ($donnees3['ID_Compte'] == $ID_Compte_soumettre && $donnees3['ID_Matiere']==$ID_Matiere ) {
                    $ID_Competence_soumettre=$donnees3['ID_Competence'];
                    if ($donnees3['Competence_valide_etudiant']!='valide'){
                        $sql = "UPDATE compte_competence SET Etat_competence = 'urgent' WHERE ID_Compte = '$ID_Compte_soumettre' AND ID_competence ='$ID_Competence_soumettre'";
                        $bdd -> query($sql);
                    }
                }
            }
        }
        
    }
}
?>


</body>

</html>