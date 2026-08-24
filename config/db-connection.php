<?php
function conectarBanco(): PDO {
try {
    $pdo = new PDO(
        "pgsql:host=localhost;port=5432;dbname=db-san-fernando",
        "postgres",     // usuário
        "19junho04"   // senha correta do postgres
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo; 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
}
