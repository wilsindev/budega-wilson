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
        // Adiciona um produto qualquer no DB. 
        // faltar colocar quantidade. 
        // fazer sistema de paginação com filtro
        public function adicionarVenda($clienteId, $vendaTotal){
            $query = $this->pdo->prepare("INSERT INTO vendas (cliente_id, total) VALUES (:cliente_id, :total)");
            $query->bindValue(":cliente_id", $clienteId);
            $query->bindValue(":total", $vendaTotal);
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
        public function getProdutosVenda($vendaId){
            $query = $this->pdo->prepare("SELECT iv.*, p.nome AS produto FROM venda_produtos iv JOIN produtos p ON iv.produto_id = p.id WHERE iv.venda_id = :venda_id");
            $query->bindValue(":venda_id", $vendaId);
            $query->execute();
            $produtosVenda = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtosVenda;
        }
   


        public function searchProdutosNome($nome){
            $nomePesquisar = "%" . $nome . "%";
            $query = $this->pdo->prepare("SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.nome LIKE :nome");
            $query->bindValue(":nome", $nomePesquisar);
            $query->execute();
            $produtos = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtos;
        }


        // Delete

        public function cancelarVenda($vendaId){
            $query = $this->pdo->prepare("DELETE FROM vendas WHERE id = :id");
            $query->bindValue(":id", $vendaId);
            $query->execute();
        }
    }
?>