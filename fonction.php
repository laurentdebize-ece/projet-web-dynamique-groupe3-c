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

function selection($PDO, $table, $where = null, $cibles = null, $cibles2 = null, $cibles3 = null, $cibles4 = null, $cible5)
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

?>