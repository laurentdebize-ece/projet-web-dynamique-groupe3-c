<?php


///////////////////////////////////////////////FONCTIONS POUR LES SELECTIONS D'INFORMATIONS DANS LA BDD///////////////////////////////////////////////
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


function selection_nouvelles_competences($bdd,$ID,$Matiere) {

        $sql="SELECT DISTINCT competence.Nom_competence, competence.ID_Competence FROM competence
            INNER JOIN matiere_competence ON competence.ID_Competence = matiere_competence.ID_Competence
            INNER JOIN matiere ON matiere_competence.ID_Matiere = matiere.ID_Matiere
            WHERE Nom_matiere = $Matiere AND competence.ID_Competence NOT IN (
            SELECT compte_competence.ID_Competence 
            FROM compte_competence 
            INNER JOIN competence ON compte_competence.ID_Competence = competence.ID_Competence 
            WHERE compte_competence.ID_Compte = '$ID'
        )";
            
    
        $exec = $bdd->prepare($sql);
        $exec->execute();

        $result = $exec->fetchAll(PDO::FETCH_ASSOC);
    return $result;

}

function selection_4_last_competences($bdd) {

    $sql = "SELECT Nom_competence FROM competence ORDER BY Date_Creation 
    LIMIT 4";

    $exec = $bdd->prepare($sql);
    $exec->execute();

    $reponses = $exec->fetchAll(PDO::FETCH_ASSOC);
    return $reponses;
}
    
            

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




/*function selectcible($PDO, $table, $where = null, $cibles)
{
    $sql = "SELECT $cibles FROM $table";
    if ($where != null) {
        $sql .= " WHERE $where";
    }
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}*/



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


/////////////////////////////////////////////FONCTION POUR LES MODIFICATIONS DE LA BDD/////////////////////////////////////////////

function supprimer($PDO, $table, $where) { //pour les attributs non clés
    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    
    return null;
}

function supprimer_matiere($PDO, $IDMATIERE) {

    $sql2 = "DELETE FROM matiere_competence WHERE ID_Matiere = $IDMATIERE";
    $sql3 = "DELETE FROM compte_matiere WHERE ID_Matiere = $IDMATIERE";
    $sql = "DELETE FROM matiere WHERE ID_Matiere = $IDMATIERE";

    $stmt2 = $PDO->prepare($sql2);
    $stmt3 = $PDO->prepare($sql3);
    $stmt = $PDO->prepare($sql);
    $stmt2->execute();
    $stmt3->execute();
    $stmt->execute();
}
function supprimer_compte($PDO, $ID) {
    $sql = "DELETE FROM compte WHERE ID_Compte = $ID";
    $sql2 = "DELETE FROM compte_competence WHERE ID_Compte = $ID";
    $sql3 = "DELETE FROM compte_matiere WHERE ID_Compte = $ID";

    $stmt2 = $PDO->prepare($sql2);
    $stmt3 = $PDO->prepare($sql3);
    $stmt = $PDO->prepare($sql);
    $stmt2->execute();
    $stmt3->execute();
    $stmt->execute();
//On doit d'abord supprimer des tables où l'ID du compte est comme clé étrangère avant de supprimer le compte//
    return null;
}

function insertion($PDO,$table, $valeur_tableau)
{
  
    $donnes = implode(", ", array_keys($valeur_tableau));
    $valeurs_donnees = ":" . implode(", :", array_keys($valeur_tableau));
    $sql = "INSERT INTO $table ($donnes) VALUES ($valeurs_donnees)";

    $stmt = $PDO->prepare($sql);
    $stmt->execute($valeur_tableau);

}


function update($bdd,$table,$colonne,$valeur) {
    $sql = "UPDATE $table SET $colonne = $valeur";
    
    $exec = $bdd->prepare($sql);
    $exec->execute();
    $reponses = $exec->fetchAll(PDO::FETCH_ASSOC);
    

    return $reponses;
}
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



//Pour les compétences tranverses = pas tt de suite
/*
function modifier_Moyenne_Professeur($PDO, $table, $nouvelleMoyenne, $ID_Professeur, $ID_Eleve) {
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
*/




?>




