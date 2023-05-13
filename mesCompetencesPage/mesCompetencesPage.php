<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $passeword="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills;
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
    <title>OMNES MySkills - Compétences</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <section id="taillePage">
     <section id="header">
        <div class=".flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.html" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../mesMatieresPage/mesMatieresPage.html" class="lienWhite">Mes matières</a></div>
            <div class="flexboxText-menu"><a href="mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.html" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section id="introHomePage">
<?php
    $reponse = $bdd->query("SELECT * FROM matieres");
    while ($donnees = $reponse->fetch()) {
            echo '<tr>
                    <td>' . $donnees['ID_Matiere'] . '</td>
                    <td>' . $donnees['Nom'] . '</td>
                    <td>' . $donnees['Volume_Horaire'] . '</td>
            </tr>';
    }
    ?>
    
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>