<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../models/Compra.php';

// Iniciar sessão
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Usuário não autenticado']);
        exit;
    }
    return $_SESSION['usuario'];
}

// Obter o método da requisição
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Roteamento das requisições
switch ($action) {
    // Autenticação
    case 'login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuario();
            $result = $usuario->login($data['email'], $data['senha']);
            
            if ($result['success']) {
                $_SESSION['usuario'] = $result['usuario'];
            }
            
            echo json_encode($result);
        }
        break;

    case 'cadastro':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuario();
            $result = $usuario->cadastrar($data['nome'], $data['email'], $data['senha']);
            
            if ($result['success']) {
                $_SESSION['usuario'] = [
                    'id' => $result['id'],
                    'nome' => $data['nome'],
                    'email' => $data['email']
                ];
            }
            
            echo json_encode($result);
        }
        break;

    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    // Cursos
    case 'cursos':
        if ($method === 'GET') {
            $curso = new Curso();
            $categoriaId = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : null;
            
            if ($categoriaId) {
                $result = $curso->listarPorCategoria($categoriaId);
            } else {
                $result = $curso->listarTodos();
            }
            
            echo json_encode($result);
        }
        break;

    // Carrinho
    case 'carrinho':
        $usuario = verificarLogin();
        $carrinho = new Carrinho();

        switch ($method) {
            case 'GET':
                $itens = $carrinho->listarItens($usuario['id']);
                echo json_encode($itens);
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $carrinho->adicionarItem($usuario['id'], $data['curso_id']);
                echo json_encode($result);
                break;

            case 'DELETE':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $carrinho->removerItem($usuario['id'], $data['curso_id']);
                echo json_encode($result);
                break;
        }
        break;

    // Compras
    case 'compras':
        $usuario = verificarLogin();
        $compra = new Compra();

        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $result = $compra->getDetalhesCompra($_GET['id'], $usuario['id']);
                } else {
                    $result = $compra->listarCompras($usuario['id']);
                }
                echo json_encode($result);
                break;

            case 'POST':
                $carrinho = new Carrinho();
                $itens = $carrinho->listarItens($usuario['id']);
                $result = $compra->finalizarCompra($usuario['id'], $itens);
                echo json_encode($result);
                break;
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint não encontrado']);
        break;
}
?> 