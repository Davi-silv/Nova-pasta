<?php
require_once __DIR__ . '/../config/database.php';

class Carrinho {
    private $conn;
    private $table = 'carrinhos';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function adicionarItem($usuarioId, $cursoId) {
        try {
            // Verificar se o curso já está no carrinho
            $stmt = $this->conn->prepare("
                SELECT id FROM {$this->table}
                WHERE usuario_id = ? AND curso_id = ?
            ");
            $stmt->execute([$usuarioId, $cursoId]);
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Curso já está no carrinho'];
            }

            // Adicionar ao carrinho
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->table} (usuario_id, curso_id)
                VALUES (?, ?)
            ");
            $stmt->execute([$usuarioId, $cursoId]);

            return ['success' => true, 'message' => 'Curso adicionado ao carrinho'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao adicionar ao carrinho: ' . $e->getMessage()];
        }
    }

    public function removerItem($usuarioId, $cursoId) {
        try {
            $stmt = $this->conn->prepare("
                DELETE FROM {$this->table}
                WHERE usuario_id = ? AND curso_id = ?
            ");
            $stmt->execute([$usuarioId, $cursoId]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao remover do carrinho: ' . $e->getMessage()];
        }
    }

    public function listarItens($usuarioId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.*, cur.titulo, cur.descricao, cur.preco, cur.imagem,
                       cat.nome as categoria_nome, cat.icone as categoria_icone
                FROM {$this->table} c
                JOIN cursos cur ON c.curso_id = cur.id
                JOIN categorias cat ON cur.categoria_id = cat.id
                WHERE c.usuario_id = ?
                ORDER BY c.data_adicao DESC
            ");
            $stmt->execute([$usuarioId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function limparCarrinho($usuarioId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE usuario_id = ?");
            $stmt->execute([$usuarioId]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao limpar carrinho: ' . $e->getMessage()];
        }
    }

    public function calcularTotal($usuarioId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT SUM(cur.preco) as total
                FROM {$this->table} c
                JOIN cursos cur ON c.curso_id = cur.id
                WHERE c.usuario_id = ?
            ");
            $stmt->execute([$usuarioId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?> 