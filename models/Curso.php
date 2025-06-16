<?php
require_once __DIR__ . '/../config/database.php';

class Curso {
    private $conn;
    private $table = 'cursos';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function listarTodos() {
        try {
            $stmt = $this->conn->query("
                SELECT c.*, cat.nome as categoria_nome, cat.icone as categoria_icone 
                FROM {$this->table} c
                JOIN categorias cat ON c.categoria_id = cat.id
                ORDER BY c.titulo
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function listarPorCategoria($categoriaId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.*, cat.nome as categoria_nome, cat.icone as categoria_icone 
                FROM {$this->table} c
                JOIN categorias cat ON c.categoria_id = cat.id
                WHERE c.categoria_id = ?
                ORDER BY c.titulo
            ");
            $stmt->execute([$categoriaId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.*, cat.nome as categoria_nome, cat.icone as categoria_icone 
                FROM {$this->table} c
                JOIN categorias cat ON c.categoria_id = cat.id
                WHERE c.id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function adicionar($dados) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->table} (categoria_id, titulo, descricao, preco, imagem)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $dados['categoria_id'],
                $dados['titulo'],
                $dados['descricao'],
                $dados['preco'],
                $dados['imagem']
            ]);
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao adicionar curso: ' . $e->getMessage()];
        }
    }

    public function atualizar($id, $dados) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE {$this->table}
                SET categoria_id = ?, titulo = ?, descricao = ?, preco = ?, imagem = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $dados['categoria_id'],
                $dados['titulo'],
                $dados['descricao'],
                $dados['preco'],
                $dados['imagem'],
                $id
            ]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao atualizar curso: ' . $e->getMessage()];
        }
    }

    public function excluir($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao excluir curso: ' . $e->getMessage()];
        }
    }
}
?> 