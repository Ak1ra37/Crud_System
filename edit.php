<?php
// ============================================
// ARQUIVO: admin/edit.php
// REQUISITO: 5 (CRUD - UPDATE)
// O QUE FAZ: Carrega o produto pelo ID e permite editar.
// ============================================

session_start();
require_once '../classes/Produto.php';

// Controle de acesso
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$p = new Produto();
$id = $_GET['id'] ?? 0;
$prod = $p->buscar($id);

// Se o produto não existir, para tudo
if (!$prod) die("Produto não encontrado.");

// Atualiza se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preco = str_replace(',', '.', $_POST['preco']);
    $p->atualizar($id, $_POST['nome'], $_POST['descricao'], $preco, $_POST['quantidade']);
    header("Location: index.php");
    exit;
}

$tema = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <div class="card" style="max-width:500px; margin:20px auto;">
        <h2 style="margin-bottom:15px;">Editar Produto</h2>
        <form method="POST">
            <input    type="text"   name="nome"
                      value="<?= htmlspecialchars($prod['nome']) ?>" required>
            <textarea name="descricao"><?= htmlspecialchars($prod['descricao']) ?></textarea>
            <input    type="text"   name="preco"
                      value="<?= number_format($prod['preco'], 2, ',', '') ?>" required>
            <input    type="number" name="quantidade"
                      value="<?= $prod['quantidade'] ?>" required>

            <button type="submit" class="btn btn-azul" style="width:100%">Atualizar</button>
            <a href="index.php" style="display:block; text-align:center; margin-top:10px;">Cancelar</a>
        </form>
    </div>
</body>
</html>