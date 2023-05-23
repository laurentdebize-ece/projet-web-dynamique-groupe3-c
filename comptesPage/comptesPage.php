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
  require_once('../fonction.php');
  $ID = $_SESSION['ID_Compte'];
  $Type_compte = $_SESSION['Type_compte'];
  $_SESSION['ID_Compte'] = $ID;
  $_SESSION['Type_compte'] = $Type_compte;
  if(isset($_SESSION['selectCompte'])){
    $Compte_Select = $_SESSION['selectCompte'];
  }
  $reponse = $bdd->query('SELECT * FROM compte');
  while ($donnees = $reponse->fetch()){
          if ($donnees['ID_Compte'] == $ID) {
              if ($donnees['Type_compte'] == 'Administrateur') {
                  
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Ajouter
                    if(isset($_POST['validerAjout'])){ 
                      $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $NewMDP = '';
                      for ($i = 0; $i < 6; $i++) {
                          $NewMDP .= $caracteres[rand(0, strlen($caracteres) - 1)];
                      }
                      $NewEmail = $_POST['NewEmail'];
                      $NewTypeCompte = $_POST['NewTypeCompte'];
                      $NewDejaCo = 0;
                      $NewNom = $_POST['NewNom'];
                      $NewPrenom = $_POST['NewPrenom'];
                      if($_POST['NewTypeCompte']=="Administrateur") {
                        $NewIDecole = 0;
                        $NewPromo = 0;
                        $NewClasse = 0;
                      }
                      if($_POST['NewTypeCompte']=="Etudiant") {
                        $NewPromo = $_POST['NewPromo'];
                        //$NewClasse = $_POST['NewClasse'];
                        $NewIDecole=$_POST['NewEcole'];
                      }
                      
                      if($_POST['NewTypeCompte']=="Professeur") {
                        //$NewMatiere = $_POST['NewMatiere'];
                        $NewIDecole=$_POST['NewEcoleProf'];
                        //$NewClasse = $_POST['NewClasseProf'];
                        $NewPromo = 0;
                      }
                      $requete = $bdd->prepare("INSERT INTO compte (Nom_Compte, Prenom, E_mail, MDP,Type_compte, Deja_connecte,ID_Ecole,ID_Promotion) VALUES ( :NewNom, :NewPrenom, :NewEmail, :NewMDP,:NewTypeCompte, :NewDejaCo, :NewIDecole, :NewPromo)");
                      $requete->bindParam(':NewNom', $NewNom);
                      $requete->bindParam(':NewPrenom', $NewPrenom);
                      $requete->bindParam(':NewEmail', $NewEmail);
                      $requete->bindParam(':NewMDP', $NewMDP);
                      $requete->bindParam(':NewTypeCompte', $NewTypeCompte);
                      $requete->bindParam(':NewDejaCo', $NewDejaCo);
                      $requete->bindParam(':NewIDecole', $NewIDecole);
                      $requete->bindParam(':NewPromo', $NewPromo);
                      $requete->execute();
                    }
                    //Supprimer
                    if(isset($_POST['validerSuppression'])){
                        if($_POST['validerSuppression']=="Valider"){
                            supprimer_compte($bdd, $Compte_Select);
                        }                        
                    }
                    /*
if(isset($_POST['validerModification'])){
    //modifier fonction
}*/
                }
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['validerAjoutEcole'])){
            $sql = "INSERT INTO ecole (Nom_Ecole) VALUES ('".$_POST['NewNomEcole']."')";
            $bdd->query($sql);
        }
        if(isset($_POST['validerAjoutPromo'])){
            $requete = $bdd->prepare( "INSERT INTO promotion (ID_Ecole, Annee_debut, Annee_fin) VALUES (:NewEcole, :NewDebut, :NewFin)");
            $requete->bindParam(':NewEcole',$_POST['NewEcole']);
            $requete->bindParam(':NewDebut', $_POST['NewAnneeDebut']);
            $requete->bindParam(':NewFin', $_POST['NewAnneeFin']);
            $requete->execute();
        }
        if(isset($_POST['validerAjoutClasse'])){

            $requete = $bdd->prepare( "INSERT INTO classe (Num_groupe, ID_Promotion) VALUES (:Newgroupe, :NewPromo)");
            $requete->bindParam(':Newgroupe', $_POST['NewNumGroupe']);
            $requete->bindParam(':NewPromo', $_POST['NewPromotion']);
            $requete->execute();
        }
    }



                                            
?>
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
    <section class="bodyComptesPage">
        <div class="login-form3">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="formChoixTri">
                <input type="radio" name="choixTriComptes" value="1" class="selectChoixTri">Nom</option>
                <input type="radio" name="choixTriComptes" value="2" class="selectChoixTri">Prénom</option>
                <input type="radio" name="choixTriComptes" value="3" class="selectChoixTri">Ecole</option>
                <input type="radio" name="choixTriComptes" value="4" class="selectChoixTri">Type de compte</option>
                <input type="submit" value="valider">
            </form>
        </div>

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
} else {$reponseComptes = $bdd->query(" SELECT * FROM compte ");} ?>
<table>
    <tr id="textLigne1">
        <th>Nom</th>
        <th>Prénom</th>
        <th>Adresse mail</th>
        <th>Type de compte</th>
        <th>Sélection</th>
    </tr>
    <form method="POST" action="modifCompte.php">
<?php while ($donneesComptes = $reponseComptes->fetch()){ ?> 
    <tr>
        <td id="textColonne1"><?php echo $donneesComptes['Nom']?></td>
        <td id="textColonne"><?php echo $donneesComptes['Prenom']?></td>
        <td id="textColonne"><?php echo $donneesComptes['E_mail']?></td>
        <td class="textColonne"><?php echo $donneesComptes['Type_compte']?></td>
        <td id="textColonneSelection"> <input type="radio" name="selectCompte" value="<?php echo $donneesComptes['ID_Compte']?>"></td>
    </tr>
<?php } ?>
</table>
<div class="login-form3">
    <div class="floatLeft">
        <input type="submit" name ="modifCompte" value="Ajouter" >
        <input type="submit" name ="modifCompte" value="Supprimer">
        <input type="submit" name ="modifCompte" value="Modifier">
        </form>
        </div>
    <form method="POST" action="creerEcolePromoClasse.php" class="floatRight">
        <input type="submit" name ="creerEcolePromoClasse" value="Créer une école">
        <input type="submit" name ="creerEcolePromoClasse" value="Créer une promo">
        <input type="submit" name ="creerEcolePromoClasse" value="Créer une classe">
    </form>
</div>
</section>
    <footer>
        <div class="floatLeft">Projet Développement Web</div>
        <div  class="floatRight">Emma Batherosse, Lucas Boj, Charles Masson et Noémie Ruat</div>
    </footer>
</body>

</html>