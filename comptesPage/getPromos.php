<?php
// Récupérer l'ID de l'école depuis la requête GET
$ID_Ecole = $_GET['ID_Ecole'];

// Effectuer une requête à la base de données pour récupérer les promotions
// en fonction de l'ID de l'école
// Assurez-vous d'utiliser des requêtes préparées pour éviter les injections SQL

// Exemple de code pour récupérer les promotions depuis la base de données
try {
    $mdp="root";
	if (strstr($_SERVER['DOCUMENT_ROOT'],"wamp")){
        $mdp="";//pas de mdp sous wamp
    }
    $pdo = new PDO('mysql:host=localhost;dbname=omnesmyskills;
        charset=utf8', 'root', $mdp);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT ID_Promotion, Annee_fin FROM promotion WHERE ID_Ecole = :ID_Ecole");
    $stmt->bindValue(':ID_Ecole', $ID_Ecole, PDO::PARAM_INT);
    $stmt->execute();

    // Générer les options HTML des promotions
    $options = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row['ID_Promotion'] . '">' . $row['Annee_fin'] . '</option>';
    }

    echo $options;
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>