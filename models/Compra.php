<?php
require_once __DIR__ . '/../config/database.php';

class Compra {
    private $conn;
    private $table = 'compras';
    private $itensTable = 'itens_compra';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function finalizarCompra($usuarioId, $carrinho) {
        try {
            $this->conn->beginTransaction();

            // Calcular valor total
            $valorTotal = 0;
            foreach ($carrinho as $item) {
                $valorTotal += $item['preco'];
            }

            // Criar a compra
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->table} (usuario_id, valor_total)
                VALUES (?, ?)
            ");
            $stmt->execute([$usuarioId, $valorTotal]);
            $compraId = $this->conn->lastInsertId();

            // Adicionar itens da compra
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->itensTable} (compra_id, curso_id, preco)
                VALUES (?, ?, ?)
            ");
            foreach ($carrinho as $item) {
                $stmt->execute([$compraId, $item['id'], $item['preco']]);
            }

            // Limpar carrinho
            $stmt = $this->conn->prepare("DELETE FROM carrinhos WHERE usuario_id = ?");
            $stmt->execute([$usuarioId]);

            $this->conn->commit();
            return ['success' => true, 'compra_id' => $compraId];
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return ['success' => false, 'message' => 'Erro ao finalizar compra: ' . $e->getMessage()];
        }
    }

    public function listarCompras($usuarioId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.*, 
                       GROUP_CONCAT(
                           CONCAT(cur.titulo, ' (R$', cur.preco, ')')
                           SEPARATOR ', '
                       ) as itens
                FROM {$this->table} c
                JOIN {$this->itensTable} i ON c.id = i.compra_id
                JOIN cursos cur ON i.curso_id = cur.id
                WHERE c.usuario_id = ?
                GROUP BY c.id
                ORDER BY c.data_compra DESC
            ");
            $stmt->execute([$usuarioId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getDetalhesCompra($compraId, $usuarioId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.*, 
                       cur.titulo, cur.descricao, cur.imagem,
                       cat.nome as categoria_nome, cat.icone as categoria_icone,
                       i.preco as preco_item
                FROM {$this->itensTable} i
                JOIN {$this->table} c ON i.compra_id = c.id
                JOIN cursos cur ON i.curso_id = cur.id
                JOIN categorias cat ON cur.categoria_id = cat.id
                WHERE c.id = ? AND c.usuario_id = ?
            ");
            $stmt->execute([$compraId, $usuarioId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?> 