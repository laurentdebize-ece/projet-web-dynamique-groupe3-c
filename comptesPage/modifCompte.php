<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Comptes</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleComptesPage.css" rel="stylesheet" type="text/css">

</head>
<script>
    function showEtudiantChamps() {
        document.getElementById("etudiantChamps").style.display = "block";
        document.getElementById("professeurChamps").style.display = "none";
    }
    function showProfesseurChamps() {
        document.getElementById("etudiantChamps").style.display = "none";
        document.getElementById("professeurChamps").style.display = "block";
    }
    function cacherExtraChamps() {
        document.getElementById("etudiantChamps").style.display = "none";
        document.getElementById("professeurChamps").style.display = "none";
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

    $reponseModifCompte = $_POST['modifCompte'];?>  
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
<section class="bodyModifCompte">
<?php if($reponseModifCompte=="Ajouter"){?>
    <div id="formulaireModifCompte"> 
        <div class="login-form2">
			<h3>Ajouter un compte</h3>
            <form method="POST" action="comptesPage.php" id="ajouterCompte">
                Nom : <input type="text" name="NewNom" placeholder="Entrez nom"required><br><br>
                Prénom : <input type="text" name="NewPrenom" placeholder="Entrez prénom"required><br><br>
                E_mail : <input type="text" name="NewEmail" placeholder="Entrez adresse mail"required><br><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant" onclick="showEtudiantChamps()"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur" onclick="showProfesseurChamps()">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur" onclick="cacherExtraChamps()">Administrateur
                    <br><br>
                <div id="etudiantChamps" style="display: none;">
                    Classe : <input type="number" name="NewClasse" placeholder="Entrez classe" min=0  ><br><br>
                    Promo : <input type="text" name="NewPromo" placeholder="Entrez promo"><br><br>
                    Ecole : <br>
                    <?php 
                        $reponse2 = $bdd->query('SELECT * FROM ecole');
                        while ($donnees2 = $reponse2->fetch()){
                    ?>
                    <input type="radio" name="NewEcole" value =" <?php echo $donnees2['Nom'] ?>" >

<?php       echo $donnees2['Nom'] . "<br><br>";  } ?>
                </div>
                <div id="professeurChamps" style="display: none;">
                    Matière : <br>
                    <?php 
                        $reponse2 = $bdd->query('SELECT * FROM matiere');
                        while ($donnees2 = $reponse2->fetch()){
                    ?>
                    <input type="radio" name="NewMatiere" value =" <?php echo $donnees2['Nom_matiere'] ?>" >

<?php       echo $donnees2['Nom_matiere'] . "<br><br>";  } ?>
                </div>
                <input type="submit" name="validerAjout" value="Enregistrer">
            </form>
        </div>
    </div>
        <?php }

if($reponseModifCompte=="Supprimer"){//Style a faire emma?>
    <div id="formulaireModifCompte"> 
        <div class="login-form2">
			<h3>Supprimer un compte</h3>
            <form method="POST" action="comptesPage.php" id="supprimerMatiere">
                Nom : <input type="text" name="NewNom" placeholder="Entrez nom"required><br><br>
                Prenom : <input type="text" name="NewPrenom" placeholder="Entrez prénom"required><br><br>
                <input type="submit" name="validerSuppression" value="Enregistrer">
            </form>
        </div>
    </div>
        <?php }

if($reponseModifCompte=="Modifier"){//Style a faire emma?>
    <div id="formulaireModifCompte"> 
        <div class="login-form2">
			<h3>Modifier un compte</h3>
            <form method="POST" action="comptesPage.php" id="modifierMatiere">
                Nom : <input type="text" name="NewNom" placeholder="Entrez nom"required><br><br>
                Prénom : <input type="text" name="NewPrenom" placeholder="Entrez prénom"required><br><br>
                E_mail : <input type="text" name="NewEmail" placeholder="Entrez adresse mail"required><br><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur">Administrateur
                <br><br>
                <input type="submit" name="validerAjout" value="Enregistrer">
            </form>
        </div>
    </div>        
        <?php }?>
</section>    
<footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>