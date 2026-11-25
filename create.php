<?php
// ============================================
// ARQUIVO: admin/create.php
// REQUISITO: 5 (CRUD - CREATE)
// O QUE FAZ: Formulário para adicionar novo produto.
// ============================================

session_start();
require_once '../classes/Produto.php';

// Controle de acesso
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = new Produto();
    // Converte "19,90" em "19.90" (padrão do banco)
    $preco = str_replace(',', '.', $_POST['preco']);
    $p->criar($_POST['nome'], $_POST['descricao'], $preco, $_POST['quantidade']);
    header("Location: index.php");
    exit;
}

$tema = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <div class="card" style="max-width:500px; margin:20px auto;">
        <h2 style="margin-bottom:15px;">Novo Produto</h2>
        <form method="POST">
            <input    type="text"   name="nome"        placeholder="Nome do Produto" required>
            <textarea name="descricao"                 placeholder="Descrição"></textarea>
            <input    type="text"   name="preco"       placeholder="Preço (Ex: 19,90)" required>
            <input    type="number" name="quantidade"  placeholder="Quantidade" value="0" required>

            <button type="submit" class="btn btn-verde" style="width:100%">Salvar</button>
            <a href="index.php" style="display:block; text-align:center; margin-top:10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>