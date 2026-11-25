<?php
// ============================================
// ARQUIVO: cadastro.php
// REQUISITO: 3 (Sessão — cadastro de usuários)
// O QUE FAZ: Insere novo usuário no banco (senha criptografada).
// ============================================

require_once 'classes/Usuario.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    try {
        $u->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['tipo']);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        // Erro de email duplicado (UNIQUE no banco)
        $erro = "Este e-mail já está cadastrado.";
    }
}

$tema = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro — CRUD_System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <div class="card" style="max-width: 400px; margin: 50px auto;">
        <h2 style="text-align:center; margin-bottom:15px;">📝 Cadastro</h2>
        <?php if ($erro) echo "<p style='color:red'>$erro</p>"; ?>

        <form method="POST">
            <input type="text"     name="nome"  placeholder="Nome completo" required>
            <input type="email"    name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <select name="tipo">
                <option value="cliente">Cliente (Comprar)</option>
                <option value="admin">Vendedor (Gerenciar)</option>
            </select>

            <button type="submit" class="btn btn-azul" style="width:100%">Cadastrar</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            <a href="login.php">Voltar ao Login</a>
        </p>
    </div>
</body>
</html>