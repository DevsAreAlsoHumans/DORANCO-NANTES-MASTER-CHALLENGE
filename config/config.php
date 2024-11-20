<?php
// config.php

// Paramètres de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_des_utilisateurs');
define('DB_USER', 'admin');
define('DB_PASS', 'admin');

// Fonction pour établir la connexion à la base de données
function getDbConnection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
        exit();
    }
}
?>
