<?php 
    require_once "conexao.php";
    class Query{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        public function adicionarProduto($produtoName, $produtoPreco, $produtoCategoria){
            $query = $this->pdo->prepare("INSERT INTO produtos (nome, preco, categoria) VALUES (:nome, :preco, :categoria)");
            $query->bindValue(":nome", $produtoName);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria", $produtoCategoria);
            $query->execute();

        }
        // Read
         
        public function listarProdutos(){
            $query = $this->pdo->query("SELECT * FROM produtos");
            $produtos = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtos;
        }

        public function getDadosProdutos($produtoId){
            $query = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
            $query->bindValue(":id", $produtoId);
            $query->execute();
            $produto = $query->fetch(PDO::FETCH_OBJ);
            return $produto;
        }






        public function removerProduto($produtoID){
            $query = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $query->bindValue(":id", $produtoID);
            $query->execute();
        }
        //atualizar
        public function atualizarProduto($produtoID, $produtoNome, $produtoPreco, $produtoCategoria){
            $query = $this->pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, categoria = :categoria WHERE id = :id");
            $query->bindValue(":id", $produtoID);
            $query->bindValue(":nome", $produtoNome);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria", $produtoCategoria);
            $query->execute();
        }
        // Compras
        public function adicionarVenda($produtoLista, $produtoTotal, $produtoVendedor){
            $query = $this->pdo->prepare("INSERT INTO produtos (produtos, total, vendedor) VALUES (:produtos, :total, :vendedor)");
            $query->bindValue(":produtos", $produtoLista);
            $query->bindValue(":total", $produtoTotal);
            $query->bindValue(":vendedor", $produtoVendedor);
            $query->execute();

        }

    }
?>