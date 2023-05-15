<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Comptes</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleComptesPage.css" rel="stylesheet" type="text/css">

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

  $reponseModifCompte = $_POST['modifCompte'];
?>     <section id="header">
<div class="flex-contain-menu">
    <div class="flexboxLogo-menu"><a href="homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
    <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
    <div class="flexboxText-menu"><a href="../mesCompetencesPage/mesCompetencesPage.php" class="lienWhite">Mes compétences</a></div>
    <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
    <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
    <?php if($Type_compte=="Administrateur"){ ?>
        <div class="flexboxText-menu"><a href="comptesPage/comptesPage.php" class="lienClique">Comptes</a></div>
    <?php } ?>
    <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
</div>
</section>
<section class="bodyModifCompte">
<?php if($reponseModifCompte=="Ajouter"){ //Style a faire emma?>
            <form method="POST" action="comptesPage.php" id="ajouterMatiere">
                Nom : <input type="text" name="NewNom"><br>
                Prénom : <input type="text" name="NewPrenom"><br>
                E_mail : <input type="email" name="NewEmail"><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur">Administrateur
                <br>
                <input type="submit" name="validerAjout" value="Enregistrer">
            </form>
        <?php }

        if($reponseModifCompte=="Supprimer"){//Style a faire emma?>
        <form method="POST" action="comptesPage.php" id="supprimerMatiere">
                Nom : <input type="text" name="NewNom"><br>
                Prenom : <input type="text" name="NewPrenom"><br>
                <input type="submit" name="validerSuppression" value="Enregistrer">
        </form>
        <?php }

        if($reponseModifCompte=="Modifier"){//Style a faire emma?>
        <form method="POST" action="comptesPage.php" id="modifierMatiere">
                Nom : <input type="text" name="NewNom"><br>
                Prénom : <input type="text" name="NewPrenom"><br>
                E_mail : <input type="email" name="NewEmail"><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur">Administrateur
                <br>
                <input type="submit" name="validerAjout" value="Enregistrer">
        </form>
        <?php }?>
</section>    
<footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>