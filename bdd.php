<?php
class BDD {
    private static ?PDO $bdd = null;

    public static function getBdd(): PDO {
        if (is_null(self::$bdd)) {
            self::$bdd = new PDO('mysql:host=localhost;dbname=omnes;charset=utf8', 'root', 'root');
        }
        return self::$bdd;
    }
}

?>