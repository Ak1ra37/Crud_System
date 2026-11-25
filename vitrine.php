<?php
// ============================================
// ARQUIVO: vitrine.php
// REQUISITO: 3 (Sessão) e 5 (Listagem de Produtos)
// O QUE FAZ: Exibe os produtos para o cliente comprar (somente leitura).
// ============================================

session_start();
require_once 'classes/Produto.php';

// Bloqueia quem não está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
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
    <title>Loja — CRUD_System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <nav class="navbar">
        <strong>🛍️ CRUD_Store</strong>
        <div>
            Olá, <?= $_SESSION['usuario_nome'] ?> |
            <a href="logout.php">Sair</a>
        </div>
    </nav>

    <div class="card">
        <h2 style="margin-bottom:15px;">Produtos Disponíveis</h2>
        <div class="grid-produtos">
            <?php foreach ($produtos as $item): ?>
                <div class="produto-card">
                    <h3><?= htmlspecialchars($item['nome']) ?></h3>
                    <p style="font-size:0.9em; color:#777; margin:5px 0;"><?= htmlspecialchars($item['descricao']) ?></p>
                    <p class="preco">R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                    <p style="font-size:0.8em;">Estoque: <?= $item['quantidade'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>