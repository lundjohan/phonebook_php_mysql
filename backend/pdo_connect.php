<?php

/*values for https://johansserver.000webhostapp.com/phonebook/show_contacts.php
$host = "localhost";
$db = "id6948683_phonebook";
$user = "id6948683_root";
$pass = "banan";
$charset = 'utf8mb4';
*/
$host = 'localhost';
$db   = 'phonebook';
$user = 'root';
$pass = 'banan';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
