<?php

function select($PDO, $table, $where = null)
{
    $sql = "SELECT * FROM $table";
    if ($where != null) {
        $sql .= " WHERE $where";
    }
    /*echo $sql;*/
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

?>


<?php

function selectcible($PDO, $table, $where = null, $cibles)
{
    $sql = "SELECT $cibles FROM $table";
    if ($where != null) {
        $sql .= " WHERE $where";
    }
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>

<?php

$colonne = array('ID_Matiere', 'Nom', 'Volume_horaire');
$string = implode(",", $colonne);
function selectcible2($PDO, $table, $string, $where = null)
{
    $sql = "SELECT $string FROM $table";
    if ($where != null) {
        $sql .= " WHERE $where";
    }
    var_dump($sql);
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

}

?>

<?php
/*
function selection($PDO, $table, $where = null, $cibles = null, $cibles2 = null, $cibles3 = null, $cibles4 = null, $cible5)
{
    $sql = "SELECT * FROM $table";
    if ($where != null) {
        $sql .= " WHERE $where";
    }
    
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
*/
?>

<?php
/*
function insertion($PDO, $table, $attribut, $valeur)
{
    $sql = "INSERT INTO `$table` (`$attribut`) VALUES ('$valeur')";

    var_dump($sql);
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $reponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reponse;

}*/



function insertion($PDO,$table, $valeur_tableau)
{
  
    $donnes = implode(", ", array_keys($valeur_tableau));
    $valeurs_donnees = ":" . implode(", :", array_keys($valeur_tableau));
    $sql = "INSERT INTO $table ($donnes) VALUES ($valeurs_donnees)";

    $stmt = $PDO->prepare($sql);
    $stmt->execute($valeur_tableau);

}

?>

<?php
function jointure($PDO, $table1, $table2, $cleEtrangere1, $cleEtrangere2,$where) {
    try {
        $sql = "SELECT *
                FROM $table1
                INNER JOIN $table2 ON $table1.$cleEtrangere1 = $table2.$cleEtrangere2";
                if ($where != null) {
                    $sql .= " WHERE $where";
                }
        
        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}


?>

<?php

function doubleJointure($PDO, $table1, $table2, $table3, $cleEtrangere1, $cleEtrangere2_1,$cleEtrangere2_2, $cleEtrangere3, $where) {
    try {
        $sql = "SELECT *
                FROM $table1
                INNER JOIN $table2 ON $table1.$cleEtrangere1 = $table2.$cleEtrangere2_1
                INNER JOIN $table3 ON $table2.$cleEtrangere2_2 = $table3.$cleEtrangere3";
        
        if ($where != null) {
            $sql .= " WHERE $where";
        }
        
        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}

?>


<?php

function supprimer($PDO, $table, $where) {
    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    
    return null;
}

?>


<?php

function modifier_Moyenne_Professeur($PDO, $table, $nouvelleMoyenne, $ID_Professeur) {
    try {
        $sql = "UPDATE $table SET moyenne_professeur = $nouvelleMoyenne WHERE $ID_Professeur = ";
        
        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        
        return true;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

?>