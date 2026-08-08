<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once __DIR__ .  "/../config/conexao.php";
    class VendaQuery{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        public function adicionarVenda($clienteId, $vendaTotal, $vendaStatus){
            $query = $this->pdo->prepare("INSERT INTO vendas (cliente_id, total, status_pagamento) VALUES (:cliente_id, :total, :status)");
            $query->bindValue(":cliente_id", $clienteId);
            $query->bindValue(":total", $vendaTotal);
            $query->bindValue(":status", $vendaStatus);
            $query->execute();
            return $this->pdo->lastInsertId(); // Retorna o ID da venda recém-criada  
        }
        public function adicionarItemVenda($vendaId, $produtoId, $quantidade, $precoUnitario){
            $query = $this->pdo->prepare("INSERT INTO venda_produtos (venda_id, produto_id, quantidade, preco_unitario) VALUES (:venda_id, :produto_id, :quantidade, :preco_unitario)");
            $query->bindValue(":venda_id", $vendaId);
            $query->bindValue(":produto_id", $produtoId);
            $query->bindValue(":quantidade", $quantidade);
            $query->bindValue(":preco_unitario", $precoUnitario);
            $query->execute();
        }


        // Read
        public function contarVendas(){
            $query = $this->pdo->query("SELECT COUNT(*) AS total FROM vendas");
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total;
        }
        public function listarProdutosVenda($vendaId){
            $query = $this->pdo->prepare("SELECT iv.*, p.nome AS produto FROM venda_produtos iv JOIN produtos p ON iv.produto_id = p.id WHERE iv.venda_id = :venda_id");
            $query->bindValue(":venda_id", $vendaId);
            $query->execute();
            $itensVenda = $query->fetchAll(PDO::FETCH_OBJ);
            return $itensVenda;
        }
        public function listarVendas($limite, $offset){
            $query = $this->pdo->prepare("SELECT v.*, c.nome AS cliente FROM vendas v LEFT JOIN clientes c ON v.cliente_id = c.id ORDER BY v.data DESC LIMIT :limit OFFSET :offset");
            $query->bindValue(':limit', (int) $limite, PDO::PARAM_INT);
            $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
        public function getDadosVenda($vendaId){
            $query = $this->pdo->prepare("
                SELECT v.*, c.nome AS cliente 
                FROM vendas v 
                LEFT JOIN clientes c ON v.cliente_id = c.id 
                WHERE v.id = :id
            ");
            $query->bindValue(":id", $vendaId);
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        }
        public function buscarVendaPorNome($nome){
            $query = $this->pdo->prepare("
                SELECT vendas.*, clientes.nome AS cliente 
                FROM vendas 
                LEFT JOIN clientes ON vendas.cliente_id = clientes.id 
                WHERE clientes.nome LIKE :nome
            ");
            $query->bindValue(":nome", "%$nome%");
            $query->execute();
            $vendasEncontradas = $query->fetchAll(PDO::FETCH_OBJ);
            return $vendasEncontradas;
        }
        public function getProdutosVenda($vendaId){
            $query = $this->pdo->prepare("SELECT iv.*, p.nome AS produto FROM venda_produtos iv JOIN produtos p ON iv.produto_id = p.id WHERE iv.venda_id = :venda_id");
            $query->bindValue(":venda_id", $vendaId);
            $query->execute();
            $produtosVenda = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtosVenda;
        }
        public function totalVendas(){
            $query = $this->pdo->query("SELECT IFNULL(SUM(total), 0) AS total FROM vendas");
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total;
        }

        // Update
        public function atualizarStatusPagamento($vendaId, $novoStatus){
            $query = $this->pdo->prepare("UPDATE vendas SET status_pagamento = :status WHERE id = :id");
            $query->bindValue(":status", $novoStatus);
            $query->bindValue(":id", $vendaId);
            $query->execute();
        }
        // Delete

        public function cancelarVenda($vendaId){
            try{
                $query = $this->pdo->prepare("DELETE FROM vendas WHERE id = :id");
                $query->bindValue(":id", $vendaId);
                $query->execute();
                return true;
            }
            catch(PDOException $e){
                return false;
            }
        }
    }
?>