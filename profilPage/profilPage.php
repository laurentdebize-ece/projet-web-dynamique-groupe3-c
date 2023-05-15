<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnes_my_skills;
charset=utf8', 'root', $mdp,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Profil</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleProfilPage.css" rel="stylesheet" type="text/css">
</head>

<body>
    <section id="taillePage"></section>
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="profilPage.php" class="lienWhite"><img src="../img/profilLogoActualPage.png" class="menuLogo" alt=" profilLogoActualPage "></a></div>
        </div>
    </section>
    <img src="../img/lyonCity.jpg"  alt=" lyonCity " id="imgLyonCityProfil">

    <?php 
    session_start();

    if (!isset($_SESSION['ID_Compte'])) {
        header('Location: ../homePage/homePage.php');
        exit();
      }
    $ID = $_SESSION['ID_Compte'];
    

    $reponse = $bdd->query('SELECT * FROM compte');
    while ($donnees = $reponse->fetch()){
		if ($donnees['ID_Compte'] == $ID) {
			$nom=$donnees['Nom'];
			$prenom=$donnees['Prenom'];
			$mail=$donnees['E_mail'];
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
        <div class="textProfil"><?php echo $mdp; ?></div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="submit" id="boutonChangementMDP" name="ChangerMDP" value="Modifier">
            <input type="submit" id="boutonDeconnexion" name="Deconnexion" value="Deconnecter">
        </form>
        <?php
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo 'tes';
        if ($_POST['ChangerMDP']=="Modifier"){
        session_start();
        $_SESSION['ID_Compte'] = $ID;
        header('Location: modifiercompte.php');
        exit();
        }
        if ($_POST['Deconnexion']=="Deconnecter"){
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