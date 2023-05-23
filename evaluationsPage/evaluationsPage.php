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
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <?php }
            if($Type_compte=="Administrateur" || $Type_compte=="Etudiant"){ ?>
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.php" class="lienWhite">Compétences transverses</a></div>
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

if ($Type_compte == "Professeur") {
    ?>
    <br> <br>
 <div class="login-form3">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="submit" name="valideaction" value="evaluation">Evaluation</option>
        <input type="submit" name="valideaction" value="auto evaluation">Auto Evaluation</option>
    </form>
    <?php
    if (isset($_POST['valideaction'])) {
				session_start();
				$_SESSION['ID_Compte'] = $ID;
				$_SESSION['Type_compte'] = $Type_compte;
                $_SESSION['action'] = $_POST['valideaction'];
				header('Location: soumettre_noter.php');
				exit();
        }

        echo "liste de vos etudiants : <br>";
        $reponsepromo2 = $bdd->query('SELECT * FROM promotion');
        while ($donneespromo2 = $reponsepromo2->fetch()) { 
            if ($donneespromo2['ID_Ecole'] == $ID_Ecole && $donneespromo2['ID_Promotion'] != 0) {
                $promo=$donneespromo2['ID_Promotion'];
                echo "Promotion : " . $donneespromo2['Annee_fin']." :<br>";
                

                $reponseclasse2 = $bdd->prepare('SELECT * FROM classe INNER JOIN promotion ON classe.ID_Promotion = promotion.ID_Promotion WHERE promotion.ID_Promotion = :promo AND promotion.ID_Ecole = :ID_Ecole');
                $reponseclasse2->bindParam(':promo', $promo);
                $reponseclasse2->bindParam(':ID_Ecole', $ID_Ecole);
                $reponseclasse2->execute();
                while ($donneesclasse2 = $reponseclasse2->fetch()) { 
                    if ($donneesclasse2['ID_Promotion'] == $promo && $donneespromo2['ID_Ecole'] == $ID_Ecole) {
                        $classe=$donneesclasse2['ID_Classe'];
                        echo "- Groupe : " . $donneesclasse2['Num_groupe']."<br>";
                        $reponseetudiant = $bdd->prepare('SELECT * FROM compte INNER JOIN compte_classe ON compte.ID_Compte=compte_classe.ID_Compte WHERE compte.ID_Promotion = :promo AND compte.ID_Ecole = :ID_Ecole AND compte.Type_compte = "Etudiant"');
                        $reponseetudiant->bindParam(':promo', $promo);
                        $reponseetudiant->bindParam(':ID_Ecole', $ID_Ecole);
                        $reponseetudiant->execute();
                        while ($donneesetudiant = $reponseetudiant->fetch()) { 
                            if ($donneesetudiant['ID_Classe'] == $classe && $donneesclasse2['ID_Promotion'] == $promo && $donneespromo2['ID_Ecole'] == $ID_Ecole) {
                                echo "-- Etudiant : " . $donneesetudiant['Nom_Compte'].' '. $donneesetudiant['Prenom'] ."<br>";
                            }
                        }


                    }
                }

            }
        } 
    }

?>
</div>


</body>

</html>