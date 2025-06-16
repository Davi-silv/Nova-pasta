<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Usuário padrão do XAMPP
define('DB_PASS', '');      // Senha padrão do XAMPP é vazia
define('DB_NAME', 'portal_tech');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8mb4");
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    die();
}
?> 