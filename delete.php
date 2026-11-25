<?php
// ============================================
// ARQUIVO: admin/delete.php
// REQUISITO: 5 (CRUD - DELETE)
// O QUE FAZ: Exclui o produto pelo ID e volta para a listagem.
// ============================================

session_start();
require_once '../classes/Produto.php';

// Controle de acesso
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

// Só exclui se veio um ID válido
if ($id) {
    $p = new Produto();
    $p->excluir($id);
}

header("Location: index.php");
exit;