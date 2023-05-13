<?php
try{
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $passeword="";//pas de mdp sous wamp
    }
	$bdd = new PDO('mysql:host=localhost;dbname=omnesmyskills; 
    charset=utf8', 'root', $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
    <title>OMNES MySkills - Toutes les compétences</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleToutesCompetences.css" rel="stylesheet" type="text/css">

</head>

<body>
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../hopePage/homePage.html" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../mesMatieresPage/mesMatieresPage.html" class="lienWhite">Mes matières</a></div>
            <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
            <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
            <div class="flexboxText-menu"><a href="toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>


    <section id="bodyToutesCompetencesPage">
    <?php
    $reponse = $bdd->query('SELECT * FROM competence');
 while ($donnees = $reponse->fetch()){
?>
    <table>
    <tr>
        <td><?php echo $donnees['Nom']?></td>
 </tr> 
 </table>
 <?php } ?>
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>