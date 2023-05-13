<?php
try{
$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
charset=utf8', 'root', 'root',
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
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.html" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../mesMatieresPage/mesMatieresPage.html" class="lienWhite">Mes matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.html" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.html" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="profilPage.php" class="lienWhite"><img src="../img/profilLogoActualPage.png" class="menuLogo" alt=" profilLogoActualPage "></a></div>
        </div>
    </section>
    <img src="../img/lyonCity.jpg"  alt=" lyonCity " id="imgLyonCityProfil">

    <?php 
    /*session_start();
    if(!isset( $_SESSION['ID_Compte'] )){
        header('Location: ../connexionPage/connexion.php');
        exit();
    }
    $_SESSION['ID_Compte'] = $ID;
    
    $reponse = $bdd->query('SELECT * FROM compte WHERE ID LIKE $ID');
    $donnees = $reponse->fetch(); */?>

    <section id="bodyProfil">
        <div class="textBoldProfil">Nom</div>
        <div class="textProfil"> <?php echo $donnees['Nom']; ?></div>
        <div class="textBoldProfil">Prénom</div>
        <div class="textProfil"><?php echo $donnees['Prenom']; ?>/div>
        <div class="textBoldProfil">Adresse e-mail</div>
        <div class="textProfil"><?php echo $donnees['E_mail']; ?></div>
        <div class="textBoldProfil">Mot de passe</div>
        <div class="textProfil">@BDDmdp</div>
        <form(method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>")>
            <input type="submit" id="boutonChangementMDP" name="ChangerMDP" value="Modifier">
        </form>
    </section>  
</section>
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>



</html>