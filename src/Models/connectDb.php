<?php

try
{
    // Connexion à la base de données
    $host = "localhost";
    $dbname = "lacosina";
    $user = "root";
    $password = "root";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}