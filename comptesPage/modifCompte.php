<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OMNES MySkills - Comptes</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="styleComptesPage.css" rel="stylesheet" type="text/css">

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
    function showPromosEtudiant(idEcole) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("promoSelectEtudiant").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "getPromotionsEcole.php?idEcole=" + idEcole, true);
        xhttp.send();
    }
    function showClassesEtudiant(idPromo) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("classeSelectEtudiant").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "getClassesPromo.php?idPromo=" + idPromo, true);
        xhttp.send();
    }
    function showClassesProf(idEcole) {
        console.log(idEcole);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("classeSelectProf").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "getClassesEcole.php?idEcole=" + idEcole, true);
        xhttp.send();
    }
    </script>
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
  if(isset($_POST['selectCompte'])){
    $_SESSION['selectCompte'] = $_POST['selectCompte'];
  }
  $reponseModifCompte = $_POST['modifCompte'];?>  
     <section id="header">
        <div class="flex-contain-menu">
            <div class="flexboxLogo-menu"><a href="../homePage/homePage.php" class="lienWhite"><img src="../img/homeLogo.png" class="menuLogo" alt=" homeLogo "></a></div>
            <div class="flexboxText-menu"><a href="../matieresPage/matieresPage.php" class="lienWhite">Matières</a></div>
            <?php if($Type_compte=="Etudiant"){ ?>
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
                <div class="flexboxText-menu"><a href="comptesPage.php" class="lienClique">Comptes</a></div>
            <?php } ?>
            <div class="flexboxLogo-menu"><a href="../profilPage/profilPage.php" class="lienWhite"><img src="../img/profilLogo.png" class="menuLogo" alt=" profilLogo "></a></div>
        </div>
    </section>
<section>
    <img src="../img/paris.jpg"  alt=" parisCity " class="tailleImgFormualaire">
    <div id="formulaireModificationCompte">
        <div class="login-form2">
            <form method="POST" action="comptesPage.php" id="ajouterCompte">
            <?php if($reponseModifCompte=="Ajouter"){?>
			    <h3>Ajouter un compte</h3>
                Nom : <input type="text" name="NewNom" placeholder="Entrez nom"required><br><br>
                Prénom : <input type="text" name="NewPrenom" placeholder="Entrez prénom"required><br><br>
                E_mail : <input type="text" name="NewEmail" placeholder="Entrez adresse mail"required><br><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant" onclick="showEtudiantChamps()"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur" onclick="showProfesseurChamps()">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur" onclick="cacherExtraChamps()">Administrateur
                    <br><br>
                <div id="etudiantChamps" style="display: none;">
                    Ecole : <select name="NewEcole" id="ecoleSelectEtudiant" onchange="showPromosEtudiant(this.value)" >
                        <option>Choisir</option>
                        <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                        while ($donneesEcole = $reponseEcole->fetch()){ ?>
                            <option value="<?php echo $donneesEcole['ID_Ecole']?>"><?php echo $donneesEcole['Nom_Ecole'] ?></option>
                        <?php } ?> 
                    </select><br><br>
                    Promo : <select name="NewPromo" id="promoSelectEtudiant" onchange="showClassesEtudiant(this.value)">
                        <option>Choisir</option>
                    </select><br><br>
                    Classe : <select name="NewClasse" id="classeSelectEtudiant">
                        <option>Choisir</option>
                    </select><br><br>
                </div>
                <div id="professeurChamps" style="display: none;">
                    Ecole : <select name="NewEcoleProf" id="ecoleSelectProf" onchange="showClassesProf(this.value)" >
                        <option>Choisir</option>
                        <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                        while ($donneesEcole = $reponseEcole->fetch()){ ?>
                            <option value="<?php echo $donneesEcole['ID_Ecole']?>"><?php echo $donneesEcole['Nom_Ecole'] ?></option>
                            <?php } ?>
                    </select><br><br>
                    Classe : <div id="classeSelectProf"></div><br>
                    Matière : <select name="NewMatiere" id="matiereSelectProf">
                        <option>Choisir</option>
                        <?php $reponseMatiere = $bdd->query('SELECT * FROM matiere');
                        while ($donneesMatiere = $reponseMatiere->fetch()){ ?>
                            <option value="<?php echo $donneesMatiere['ID_Matiere']?>"><?php echo $donneesMatiere['Nom_matiere'] ?></option>
                        <?php } ?> 
                    </select><br><br>
                </div>
                <input type="submit" name="validerAjout" value="Enregistrer">
                <?php }

                if($reponseModifCompte=="Supprimer"){
                if(isset($_POST['selectCompte'])){?>
                    <h3>Etes vous sur de vouloir supprimer le compte ?</h3>
                    <input type="submit" name="validerSuppression" value="Valider"> 
                    <input type="submit" name="validerSuppression" value="Annuler"> 
                <?php } else {?>
                    <h3>Veuillez sélectionner un compte à supprimer !</h3>
                    <input type="submit" name="retourMenu" value="Retour">
                <?php }
                }
                if($reponseModifCompte=="Modifier"){
                if(isset($_POST['selectCompte'])){?>
                <h3>Modifier un compte</h3>
                Nom : <input type="text" name="NewNom" placeholder="Entrez nom"required><br><br>
                Prénom : <input type="text" name="NewPrenom" placeholder="Entrez prénom"required><br><br>
                Email : <input type="text" name="NewEmail" placeholder="Entrez adresse mail"required><br><br>
                Type de compte:<br>
                    <input type="radio" name="NewTypeCompte" value="Etudiant" onclick="showEtudiantChamps()"> Etudiant
                    <input type="radio" name="NewTypeCompte" value="Professeur" onclick="showProfesseurChamps()">Professeur
                    <input type="radio" name="NewTypeCompte" value="Administrateur" onclick="cacherExtraChamps()">Administrateur
                    <br><br>
                <div id="etudiantChamps" style="display: none;">
                    Ecole : <select name="NewEcole" id="ecoleSelectEtudiant" onchange="showPromosEtudiant(this.value)" >
                        <option>Choisir</option>
                        <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                        while ($donneesEcole = $reponseEcole->fetch()){ ?>
                            <option value="<?php echo $donneesEcole['ID_Ecole']?>"><?php echo $donneesEcole['Nom_Ecole'] ?></option>
                        <?php } ?> 
                    </select><br><br>
                    Promo : <select name="NewPromo" id="promoSelectEtudiant" onchange="showClassesEtudiant(this.value)">
                        <option>Choisir</option>
                    </select><br><br>
                    Classe : <select name="NewClasse" id="classeSelectEtudiant">
                        <option>Choisir</option>
                    </select><br><br>
                </div>
                <div id="professeurChamps" style="display: none;">
                    Ecole : <select name="NewEcoleProf" id="ecoleSelectProf" onchange="showClassesProf(this.value)" >
                        <option>Choisir</option>
                        <?php $reponseEcole = $bdd->query('SELECT * FROM ecole');
                        while ($donneesEcole = $reponseEcole->fetch()){ ?>
                            <option value="<?php echo $donneesEcole['ID_Ecole']?>"><?php echo $donneesEcole['Nom_Ecole'] ?></option>
                        <?php } ?> 
                    </select><br><br>
                    Classe : <div id="classeSelectProf"></div><br>
                    Matière : <select name="NewMatiere" id="matiereSelectProf">
                        <option>Choisir</option>
                        <?php $reponseMatiere = $bdd->query('SELECT * FROM matiere');
                        while ($donneesMatiere = $reponseMatiere->fetch()){ ?>
                            <option value="<?php echo $donneesMatiere['ID_Matiere']?>"><?php echo $donneesMatiere['Nom_matiere'] ?></option>
                        <?php } ?> 
                    </select><br><br>
                </div>
                <input type="submit" name="validerModification" value="Enregistrer">
                <?php 
                }
                else {?>
                    <h3>Veuillez sélectionner un compte à modifier !</h3>
                    <input type="submit" name="retourMenu" value="Retour">
                <?php }
            }
                ?>
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
