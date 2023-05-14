<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Accueil</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleHomePage.css" rel="stylesheet" type="text/css">

</head>

<body>
<?php
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

    <section id="taillePage">
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../mesMatieresPage/mesMatieresPage.html" class="lienWhite">Mes matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="introHomePage">
        <h1> <img src="../img/omnesSkills.png"  alt=" omnesSkills " id="tailleImgOmnesSkills"> </h1>
        <div class="intro">blaaaaaaaaaaaaaaaaaaaaablaaaaaaaaaaaaaaaaaaaaaaaaaaa<br>blaaaaaaaaaaaaaaaaaaaaaaaaaaablaaaaaaaaaaaaaaaaaaaaaaa </div>
    <section id="competencesPopulaires">
        <h2> Les compétences les plus populaires </h2>
        <div style="height:500px; width: 50px; background-color: #002B44; margin-bottom: 10px;"></div>
    </section> 
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>