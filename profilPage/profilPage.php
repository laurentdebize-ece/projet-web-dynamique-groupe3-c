<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', $mdp,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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

  function compterCaracteresMDP($chaineCaracteres) {
    $n = 0;
    for ($i = 0; $i < strlen($chaineCaracteres); $i++) {
        $n++;
    }
    return $n;
}?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Profil</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleProfilPage.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>
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
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.php" class="lienWhite">Compétences transverses</a></div>
                <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
                <?php }
            if($Type_compte=="Professeur"){ ?>
                <div class="flexboxText-menu"><a href="../evaluationsPage/evaluationsPage.php" class="lienWhite">Evaluations</a></div>
            <?php }
            if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="../comptesPage/comptesPage.php" class="lienWhite">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="profilPage.php" class="lienClique"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <img src="../img/lyonCity.jpg"  alt=" lyonCity " id="imgLyonCityProfil">

    <?php 
    
    $reponse = $bdd->query('SELECT * FROM compte');
    while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
            //if($Type_compte == "Administrateur") {
                $nom=$donnees['Nom_Compte'];
                $prenom=$donnees['Prenom'];
                $mail=$donnees['E_mail'];
            //}
            $mdp=$donnees['MDP'];
		}
}
?>
    <section id="bodyProfil">
        <div class="textBoldProfil">Nom</div>
        <div class="textProfil"> <?php echo $nom; ?></div>
        <div class="textBoldProfil">Prénom</div>
        <div class="textProfil"><?php echo $prenom; ?></div>
        <div class="textBoldProfil">Adresse e-mail</div>
        <div class="textProfil"><?php echo $mail; ?></div>
        <div class="textBoldProfil">Mot de passe</div>
        <div class="textProfil">
        <?php $nbCaracteresMDP = compterCaracteresMDP($mdp);
        for($i=0; $i<$nbCaracteresMDP; $i++){
            echo '*';
        }?>
        </div>
        <div class="login-form3">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="submit" name="ChangerMDP" value="Modifier">
                <input type="submit" name="Deconnexion" value="Déconnecter">
            </form>
        </div>
        <?php
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo 'tes';
        if ($_POST['ChangerMDP']=="Modifier"){
        session_start();
        $_SESSION['ID_Compte'] = $ID;
        header('Location: modifierMonProfil.php');
        exit();
        }
        if ($_POST['Deconnexion']=="Déconnecter"){
            session_start();
            header('Location: ../connexionPage/connexionPage.html');
            exit();
            }
    }
    ?>
    </section>  
</section>
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>

</body>



</html>