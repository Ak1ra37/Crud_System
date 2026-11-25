<?php
// ============================================
// ARQUIVO: login.php
// REQUISITO: 3 (Sessão) e 4 (Cookie)
// O QUE FAZ: Autentica o usuário, cria a sessão e o cookie do tema.
// ============================================

require_once 'classes/Usuario.php';
session_start();

$erro = '';

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    $user = $u->login($_POST['email'], $_POST['senha']);

    if ($user) {
        // === SESSÃO: mantém o usuário logado ===
        $_SESSION['usuario_id']   = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        $_SESSION['usuario_tipo'] = $user['tipo'];

        // === COOKIE: guarda o tema por 30 dias ===
        setcookie('tema_usuario', $user['tema_preferido'], time() + (86400 * 30), "/");

        // Redireciona por tipo (admin vai pro painel, cliente pra vitrine)
        header("Location: " . ($user['tipo'] === 'admin' ? 'admin/index.php' : 'vitrine.php'));
        exit;
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}

// Lê o tema do cookie (ou 'claro' se não existir)
$tema = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login — CRUD_System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $tema === 'escuro' ? 'escuro' : '' ?>">
    <div class="card" style="max-width: 400px; margin: 50px auto;">
        <h2 style="text-align:center; margin-bottom:15px;">🔐 Login</h2>
        <?php if ($erro) echo "<p style='color:red'>$erro</p>"; ?>

        <form method="POST">
            <input type="email"    name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha"  required>
            <button type="submit" class="btn btn-azul" style="width:100%">Entrar</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            Não tem conta? <a href="cadastro.php">Cadastre-se</a>
        </p>
    </div>
</body>
</html>