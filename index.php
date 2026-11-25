<?php
// ============================================
// ARQUIVO: admin/index.php
// REQUISITO: 3 (Sessão) e 5 (CRUD - Listagem)
// O QUE FAZ: Lista produtos com botões de Editar/Excluir (só admin acessa).
// ============================================

session_start();
require_once '../classes/Produto.php';

// Controle de acesso: só admin entra
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$tema = $_COOKIE['tema_usuario'] ?? 'claro';
$p = new Produto();
$produtos = $p->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin — CRUD_System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <nav class="navbar">
        <strong>⚙️ Painel do Vendedor</strong>
        <div>
            <?= $_SESSION['usuario_nome'] ?> |
            <a href="../logout.php">Sair</a>
        </div>
    </nav>

    <div class="card">
        <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
            <h2>Gerenciar Produtos</h2>
            <div>
                <a href="importar.php" class="btn btn-azul">Importar CSV</a>
                <a href="create.php"   class="btn btn-verde">+ Novo</a>
            </div>
        </div>

        <table>
            <tr>
                <th>ID</th><th>Nome</th><th>Preço</th><th>Estoque</th><th>Ações</th>
            </tr>
            <?php foreach ($produtos as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['nome']) ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $item['id'] ?>" class="btn btn-azul" style="padding:4px 8px; font-size:12px;">Editar</a>
                    <a href="delete.php?id=<?= $item['id'] ?>" class="btn btn-vermelho" style="padding:4px 8px; font-size:12px;" onclick="return confirm('Excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>