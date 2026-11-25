<?php
// ============================================
// ARQUIVO: classes/Usuario.php
// REQUISITO: 2 (POO) e 3 (Autenticação)
// O QUE FAZ: Gerencia o login e cadastro de usuários.
// ============================================

require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn; // Guarda a conexão

    // Construtor — roda ao fazer "new Usuario()"
    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    // ---------- LOGIN ----------
    public function login($email, $senha) {
        // Busca usuário pelo e-mail (prepared statement evita SQL Injection)
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // password_verify compara senha digitada com o hash salvo
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return false;
    }

    // ---------- CADASTRO ----------
    public function cadastrar($nome, $email, $senha, $tipo) {
        // Gera hash seguro da senha (nunca salvamos texto puro!)
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nome, $email, $hash, $tipo]);
    }
}
?>