<?php
// ============================================
// ARQUIVO: classes/Produto.php
// REQUISITO: 2 (POO) e 5 (CRUD de Produtos)
// O QUE FAZ: Contém os 4 métodos do CRUD (listar, buscar, criar, atualizar, excluir).
// ============================================

require_once __DIR__ . '/../config/database.php';

class Produto {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    // ---------- READ (listar todos) ----------
    public function listar() {
        return $this->conn->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll();
    }

    // ---------- READ (buscar um só, para editar) ----------
    public function buscar($id) {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ---------- CREATE ----------
    public function criar($nome, $desc, $preco, $qtd) {
        $stmt = $this->conn->prepare(
            "INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nome, $desc, $preco, $qtd]);
    }

    // ---------- UPDATE ----------
    public function atualizar($id, $nome, $desc, $preco, $qtd) {
        $stmt = $this->conn->prepare(
            "UPDATE produtos SET nome=?, descricao=?, preco=?, quantidade=? WHERE id=?"
        );
        return $stmt->execute([$nome, $desc, $preco, $qtd, $id]);
    }

    // ---------- DELETE ----------
    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>