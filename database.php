<?php
// ============================================
// ARQUIVO: config/database.php
// REQUISITO: 1 (Banco de Dados e Conexão via PDO)
// O QUE FAZ: Cria a classe responsável por conectar ao MySQL.
// ============================================

class Database {
    // Dados de conexão — encapsulados (private) para não vazar
    private $host   = 'localhost';
    private $dbname = 'crud_system';
    private $user   = 'root';
    private $pass   = '';

    // Método público que devolve uma conexão PDO pronta
    public function conectar() {
        try {
            // Cria a conexão usando DSN (host + banco + charset)
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->pass
            );

            // Faz o PDO lançar exceções em erros (mais seguro)
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Padroniza retorno como array associativo ['nome' => 'X']
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conn;

        } catch (PDOException $e) {
            // Se falhar, interrompe tudo com a mensagem de erro
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}
?>