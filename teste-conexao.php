<?php
require_once 'config/database.php';

try {
    // Testar conexão
    echo "Conexão com o banco de dados estabelecida com sucesso!<br>";
    
    // Testar consulta
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total de usuários cadastrados: " . $result['total'] . "<br>";
    
    // Listar usuários
    $stmt = $conn->query("SELECT id, nome, email, data_cadastro FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Lista de Usuários:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th><th>Data Cadastro</th></tr>";
    
    foreach ($usuarios as $usuario) {
        echo "<tr>";
        echo "<td>" . $usuario['id'] . "</td>";
        echo "<td>" . $usuario['nome'] . "</td>";
        echo "<td>" . $usuario['email'] . "</td>";
        echo "<td>" . $usuario['data_cadastro'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?> 