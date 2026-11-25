<?php
// ============================================
// ARQUIVO: classes/Importar.php
// REQUISITO: 2 (POO) e 6 (Importação de Dados)
// O QUE FAZ: Lê um arquivo CSV e insere cada linha como produto no banco.
// ============================================

require_once __DIR__ . '/../config/database.php';

class Importar {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function importarCSV($arquivo) {
        // Abre o arquivo em modo leitura
        $handle = fopen($arquivo, "r");

        // Pula a primeira linha (cabeçalho: nome,descricao,preco,quantidade)
        fgetcsv($handle, 1000, ",");

        $qtd = 0;

        // fgetcsv lê linha por linha, separando pelas vírgulas
        while (($linha = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($linha) >= 4) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES (?, ?, ?, ?)"
                );
                $stmt->execute([
                    $linha[0],
                    $linha[1],
                    str_replace(',', '.', $linha[2]), // Preço: vírgula → ponto
                    (int)$linha[3]
                ]);
                $qtd++;
            }
        }

        fclose($handle);
        return $qtd; // Retorna quantos produtos foram importados
    }
}
?>