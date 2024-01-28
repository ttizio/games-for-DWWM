<?php

require_once "../config/DbConfig.php";

/**
 * Base repository class. All application's repositories must extends this class.
 */
abstract class BaseRepository {

    /**
     * Singleton of PDO instance. Get instance with getPDO() method.
     */
    private static PDO|null $_pdo = null;

    /**
     * Get uniq instance of PDO.
     */
    protected function getDb(): PDO {
        global $DB_CONFIG;

        if(self::$_pdo === null) {
            self::$_pdo = new PDO("mysql:dbname=" . $DB_CONFIG["dbname"] . ";host=" . $DB_CONFIG["dbhost"], $DB_CONFIG["dbuser"], $DB_CONFIG["dbpassword"]);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Erreurs SQL transformé en erreurs PHP
            self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // Mode de récupération
        }

        return self::$_pdo;
    }
}
