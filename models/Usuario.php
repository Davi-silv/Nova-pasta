<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn;
    private $table = 'usuarios';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function cadastrar($nome, $email, $senha) {
        try {
            // Verificar se email já existe
            $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Email já cadastrado'];
            }

            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir novo usuário
            $stmt = $this->conn->prepare("INSERT INTO {$this->table} (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash]);

            return ['success' => true, 'message' => 'Usuário cadastrado com sucesso'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }

    public function login($email, $senha) {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome, email, senha FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                unset($usuario['senha']); // Remove a senha do array
                return ['success' => true, 'usuario' => $usuario];
            }

            return ['success' => false, 'message' => 'Email ou senha inválidos'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao fazer login: ' . $e->getMessage()];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome, email FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
?> 