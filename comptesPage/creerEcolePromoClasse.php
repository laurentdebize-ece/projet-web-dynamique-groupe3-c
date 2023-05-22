<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Création</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleComptesPage.css" rel="stylesheet" type="text/css">
    </head>
<script>
            function showPromos(idEcole) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("promoSelect").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "getPromotions.php?idEcole=" + idEcole, true);
        xhttp.send();
    }
    function showClasses(idPromo) {
        console.log(idPromo);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("classeSelect").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "getClasses.php?idPromo=" + idPromo, true);
        xhttp.send();
    }
    </script>

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
$reponseCreation = $_POST['creerEcolePromoClasse'];?>

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
                <div class="flexboxText-menu"><a href="../competencesTransversesPage/competencesTransversesPage.html" class="lienWhite">Compétences transverses</a></div>
                <div class="flexboxText-menu"><a href="../toutesCompetencesPage/toutesCompetencesPage.php" class="lienWhite">Toutes les compétences</a></div>
            <?php }
            if($Type_compte=="Professeur"){ ?>
                <div class="flexboxText-menu"><a href="../evaluationsPage/evaluationsPage.php" class="lienWhite">Evaluations</a></div>
            <?php }
            if($Type_compte=="Administrateur"){ ?>
                <div class="flexboxText-menu"><a href="comptesPage.php" class="lienClique">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
    <section>
    <img src="../img/paris.jpg"  alt=" parisCity " class="tailleImgFormualaire">
    <div class="formulaireModification">
        <div class="login-form2">
            <form method="POST" action="comptesPage.php" id="ajouterCompte">
                <?php if($reponseCreation == "Créer une école"){ ?>
                <h3>Ajouter une école</h3>
                Nom de l'école : <input type="text" name="NewNomEcole" placeholder="Entrez nom"required><br><br>
                <input type="submit" name="validerAjoutEcole" value="Enregistrer">
                <?php }
                if($reponseCreation == "Créer une promo") { ?>
                <h3>Ajouter une promo</h3>
                Année de début : <input type="number" name="NewAnneeDebut" placeholder="Entrez annéee début"required min=0><br><br>
                Année de fin : <input type="number" name="NewAnneeFin" placeholder="Entrez annéee fin"required min=0><br><br>
                Ecole : <select name="NewEcole">
                    <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                    while ($donneesEcole = $reponseEcole->fetch()){ ?>
                    <option value="<?php $donneesEcole['ID_Ecole'] ?>"><?php echo $donneesEcole['Nom'] ?></option>
                    <?php } ?>
                </select><br><br>
                <input type="submit" name="validerAjoutPromo" value="Enregistrer">
                <?php }
                if($reponseCreation == "Créer une classe") { ?>
                <h3>Ajouter une classe</h3>
                Numéro du groupe : <input type="number" name="NewNumGroupe" placeholder="Entrez numéro du groupe"required min=0><br><br>
                Nombre d'étudiants : <input type="number" name="NewNombreEtudiants" placeholder="Entrez nombre d'étudiants"required min=0><br><br>
                Ecole : <select name="NewEcole" id="selectEcole" onchange="showPromos(this.value)">
                    <option>Choisir</option>
                    <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                    while ($donneesEcole = $reponseEcole->fetch()){ ?>
                    <option value="<?php echo $donneesEcole['ID_Ecole'] ?>"><?php echo $donneesEcole['Nom'] ?></option>
                    <?php } ?>  
                </select><br><br>
                Promotion : <select name="NewPromotion" id="promoSelect">
                    <option>Choisir</option>
                </select><br><br>
                <input type="submit" name="validerAjoutClasse" value="Enregistrer">
                <?php } ?>
                
            </form>
        </div>
    </div>
  </section>
  <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>