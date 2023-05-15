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


/*if(isset($_POST['validerAjout'])){
    $tab_matiere = [
        "ID_matiere" => NULL,
        "Nom_matiere" => $_POST['NewNom'],
        "Volume_horaire" => $_POST['NewVolumeHoraire']
    ];
    insertion($bdd,"matiere", $tab_matiere);
}

if(isset($_POST['validerSupression'])){
    //$tab_matiere = array('Nom_matiere' => $_POST['NewNom']);
    //$sql=("DELETE FROM matiere WHERE `matiere`.`Nom_matiere`='$_POST['NewNom']'");
    //$stmt = $PDO->prepare($sql);
    //$stmt->execute();
    supprimer($bdd, "matiere", "Nom_matiere=$nom");//Ca supprime passsssss
} 

if(isset($_POST['validerModification'])){
    //modifier fonction
}*/

?>
     <section id="header">
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
    <section class="bodyComptesPage">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="formChoixTriComptes">
        <input type="radio" name="choixTriComptes" value="1" id="selectChoixTriComptes">Nom</option>
        <input type="radio" name="choixTriComptes" value="2" id="selectChoixTriComptes">Prénom</option>
        <input type="radio" name="choixTriComptes" value="3" id="selectChoixTriComptes">Ecole</option>
        <input type="radio" name="choixTriComptes" value="4" id="selectChoixTriComptes">Type de compte</option>
        <input type="submit" value="valider">
</form>

<?php if(isset($_POST['choixTriComptes'])){
    switch($_POST['choixTriComptes']) {
        case 1 : //ordre alphabétique des noms
            $reponseComptes = $bdd->query(" SELECT * FROM compte ORDER BY Nom ");
            break;
        case 2 : //ordre alphabétique des prénoms
            $reponseComptes = $bdd->query(" SELECT * FROM compte ORDER BY Prenom ");
            break;
        case 3 : //ecole
            $reponseComptes = $bdd->query(" SELECT * FROM compte ORDER BY ID_Ecole ");
            break;
        case 4 : //type compte
            $reponseComptes = $bdd->query(" SELECT * FROM compte ORDER BY Type_compte ");
            break;
        default :
            $reponseComptes = $bdd->query(" SELECT * FROM compte ");
            break;
    }
} else {$reponseComptes = $bdd->query(" SELECT * FROM compte ");}
?>
<table>
    <tr id="textLigne1">
        <td>Nom</td>
        <td>Prénom</td>
        <td>Adresse mail</td>
        <td>Type de compte</td>
    </tr>
<?php while ($donneesComptes = $reponseComptes->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesComptes['Nom']?></td>
        <td id="textColonne"><?php echo $donneesComptes['Prenom']?></td>
        <td id="textColonne"><?php echo $donneesComptes['E_mail']?></td>
        <td class="textColonne"><?php echo $donneesComptes['Type_compte']?></td>
    </tr>
<?php } ?>
</table>
<form method="POST" action="modifCompte.php" id="formModifCompte">
    <input type="submit" name ="modifCompte" value="Ajouter" class="boutonModif">
    <input type="submit" name ="modifCompte" value="Supprimer" class="boutonModif">
    <input type="submit" name ="modifCompte" value="Modifier" class="boutonModif">
</form>
</section>
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>