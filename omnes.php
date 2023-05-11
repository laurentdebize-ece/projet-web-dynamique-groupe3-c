<?php
/*//identifier le nom de base de données
$database = "omnes";
//connectez-vous dans votre BDD
//Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien)
$db_handle = mysqli_connect('localhost', 'root', 'root' );
$db_found = mysqli_select_db($db_handle, $database);
//si le BDD existe, faire le traitement
if ($db_found) {
$sql = "SELECT * FROM matiere";
$result = mysqli_query($db_handle, $sql);
while ($data = mysqli_fetch_assoc($result)) {
echo "ID: " . $data['ID Matière'] . '<br>';
echo "Nom:" . $data['Nom'] . '<br>';
echo "Volume Horaire: " . $data['Volume horaire'] . '<br>';
}//end while
}//end if
//si le BDD n'existe pas
else {
echo "Database not found";
}//end else
//fermer la connection
mysqli_close($db_handle);*/
?>

<?php
/*
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "omnes";
// Créer une connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Vérifier la connexion
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
// Écrire la requête SQL pour sélectionner les noms des matières
$sql = "SELECT Nom FROM matière 
WHERE `Volume horaire` > 10";
// Exécuter la requête SQL
$result = mysqli_query($conn, $sql);
// Vérifier si la requête a réussi
if ($result) {
// Afficher le nombre de résultats
$num_rows = mysqli_num_rows($result);
echo "Nombre de résultats : " . $num_rows . "<br>";
// Afficher les noms des matières
while ($row = mysqli_fetch_assoc($result)) {
echo "Nom de la matière : " . $row["Nom"] . "<br>";
}
} else {
// Afficher l'erreur si la requête a échoué
echo "Erreur : " . mysqli_error($conn);
}
// Fermer la connexion à la base de données
mysqli_close($conn);
*/
?>

<?php
/*
require_once('fonction.php');
try
{
$bdd = new PDO('mysql:host=localhost;dbname=omnes;
charset=utf8', 'root', 'root',
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
$reponse = $bdd->query('SELECT * FROM matiere');
// On affiche chaque entr´ee une `a une
while ($donnees = $reponse->fetch())
{
?>
<p>
Nom : <?php echo $donnees['Nom']; ?>,<br>
Volume horaire : <?php echo $donnees['Volume_horaire']; ?>, <br>
ID : <?php echo $donnees['ID_Matiere']; ?>, <br>
</p>
<?php
}
//On termine le traitement de la requ^ete
$reponse->closeCursor();*/
?>

<?php
require_once('fonction.php');
try {
    $bdd = new PDO('mysql:host=localhost; 
charset=utf8',
        'root',
        'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

try {
    $bdd->exec('USE Omnes_my_skills;');
} catch (PDOException $e) {
    $sql = file_get_contents('./BDD/Omnes.sql');
    $bdd->exec($sql);
}

$reponse = select($bdd, 'matiere', "Nom = 'Physique'");
foreach ($reponse as $donnees) {
    echo "ID : " . $donnees['ID_Matiere'] . "<br>";
    echo "Nom : " . $donnees['Nom'] . "<br>";
    echo "Volume horaire : " . $donnees['Volume_horaire'] . "<br>";
}
/*foreach ($donnees as $key => $value) {
echo $key . ' : ' . $value . '<br>';
}*/
/*$reponse = $bdd->query('SELECT * FROM matiere');
// On affiche chaque entr´ee une `a une
while ($donnees = $reponse->fetch())
{
?>
<p>
Nom : <?php echo $donnees['Nom']; ?>,<br>
Volume horaire : <?php echo $donnees['Volume_horaire']; ?>, <br>
ID : <?php echo $donnees['ID_Matiere']; ?>, <br>
</p>
<?php
}
//On termine le traitement de la requ^ete
$reponse->closeCursor();*/
?>
<?php
/*
require_once('bdd.php');
$bdd = BDD::getBdd();
*/
?>