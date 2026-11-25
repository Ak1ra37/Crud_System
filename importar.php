<?php
// ============================================
// ARQUIVO: admin/importar.php
// REQUISITO: 6 (Importação de Dados)
// O QUE FAZ: Faz upload de um CSV e chama a classe Importar.
// ============================================

session_start();
require_once '../classes/Importar.php';

// Controle de acesso
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$msg = '';

// Se um arquivo foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    if ($_FILES['csv']['error'] === UPLOAD_ERR_OK) {
        $imp = new Importar();
        $qtd = $imp->importarCSV($_FILES['csv']['tmp_name']);
        $msg = "✅ $qtd produto(s) importado(s) com sucesso!";
    } else {
        $msg = "❌ Erro no upload do arquivo.";
    }
}

$tema = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Importar CSV</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <div class="card" style="max-width:500px; margin:20px auto;">
        <h2 style="margin-bottom:15px;">📁 Importar CSV</h2>

        <?php if ($msg) echo "<p style='margin-bottom:10px;'>$msg</p>"; ?>

        <p style="font-size:0.85em; color:#777; margin-bottom:10px;">
            Formato esperado: <code>nome,descricao,preco,quantidade</code>
        </p>

        <!-- enctype multipart é OBRIGATÓRIO para upload de arquivo -->
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="csv" accept=".csv" required>
            <button type="submit" class="btn btn-azul" style="width:100%">Importar</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            <a href="index.php">← Voltar</a>
        </p>
    </div>
</body>
</html>