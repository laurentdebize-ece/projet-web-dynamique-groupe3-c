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
        <table>
            <tr id="textLigne1">
                <td>Compétences</td>
            </tr>
        <?php $reponseCompetence = $bdd->query('SELECT * FROM competence');
        $reponseCompteCompetence = $bdd->query('SELECT * FROM compte_competence');
        //$donneesCompteCompetence = $reponseCompteCompetence->fetch()
        while ($donneesCompetence = $reponseCompetence->fetch()){ ?> 
            <tr id="textColonne1">
                <td><?php echo $donneesCompetence['Nom']?></td>
            </tr> 
            <tr id="textColonne">
            <?php if($CompteCompetence['ID_Compte']==1){?>
                <td>
                    valide
                </td>
            <?php }
         } ?>
            </tr>
        </table>
        
    </section>  
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>