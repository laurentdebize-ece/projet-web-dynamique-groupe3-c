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
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
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
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="introHomePage">
        <h1> <img src="../img/omnesSkills.png"  alt=" omnesSkills " id="tailleImgOmnesSkills"> </h1>
        <img src="../img/HomePageLyon.jpeg"  alt=" lyonHP" id="imgLyonHP">
        <div class="intro">
            Ce site web permet aux professeurs de lister les compétences à
            acquérir dans leur matière, tandis que les étudiants pourront 
            s'auto-évaluer pour chaque compétence. Le but étant que les 
            étudiants comprendre leur niveau et à identifier les domaines
            dans lesquels ils doivent s'améliorer.</div>
    
    </section>
    <section>
        <h4> Les compétences les plus populaires </h4>
        <div class="flex-container-mesMatieresHP">
            <div class="flexboxMatieresHP"><a href="mathematiquesPage.php" class="lienWhite"><br><br><br>C'est censé être des compétences</a></div>
            <div class="flexboxMatieresHP"><a href="physiquePage.php" class="lienWhite"><br><br><br>C'est censé être des compétences</a></div>
            <div class="flexboxMatieresHP"><a href="electroniquePage.php" class="lienWhite"><br><br><br>C'est censé être des compétences</a></div>
            <div class="flexboxMatieresHP"><a href="informatiquePage.php" class="lienWhite"><br><br><br>C'est censé être des compétences</a></div>
        </div>
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>