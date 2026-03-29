<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once "conexao.php";
    class Query{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        // Adiciona um produto qualquer no DB. 
        public function adicionarProduto($produtoName, $produtoPreco, $produtoCategoria){
        //                                Inserir Na   Tabela     Colunas da tabela   Valores  Aqui são os placeholders que vão ser substituidos.
            $query = $this->pdo->prepare("INSERT INTO produtos (nome, preco, categoria) VALUES (:nome, :preco, :categoria)");
        //                  Placeholder  Variavel que vai substituir o placeholder.
            $query->bindValue(":nome", $produtoName);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria", $produtoCategoria);
        // Executa sua query.  
            $query->execute();
        }
        // Read
         
        //  Lista TODOS os produtos no DB
        public function listarProdutos(){
        //Sintaxe                  Selecionar Tudo Da Tabela  
            $query = $this->pdo->query("SELECT * FROM produtos");
        //                 PegarTudoQueVeio em formato de objeto. PDO::FETCH_ASSOC também pode ser usado, retornando tudo em forma de"dicionário"  
            $produtos = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtos;
        }

        // Pega apenas um produto e seus dados no DB  usando seu ID que é único.
        public function getDadosProdutos($produtoId){
        //Sintaxe                    Selecionar Tudo Da Tabela  Onde o id no DB seja igual ao id inserido pelo user.
            $query = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
            $query->bindValue(":id", $produtoId);
            $query->execute();
            $produto = $query->fetch(PDO::FETCH_OBJ);
            return $produto;
        }

        // Filtra os produtos por categoria 
        public function filtrarProdutosCategoria($filtro){
        //Sintaxe                    Selecionar Tudo Da Tabela  Onde  categoria no DB seja igual a categoria inserida pelo user
            $query = $this->pdo->prepare("SELECT * FROM produtos WHERE categoria = :categoria");
            $query->bindValue(":categoria", $filtro);
            $query->execute();
            $produtosFiltrados = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtosFiltrados;
        }

        // Pega as categorias que estão no DB. O DISTINCT serve para não pegar duplicatas. Esse código aqui é usada nas options do select lá em filtrar.
        public function listarCategorias(){
            $query = $this->pdo->query("SELECT DISTINCT categoria FROM produtos");
            $categorias = $query->fetchAll(PDO::FETCH_OBJ);
            return $categorias;
        }

        //Update
        // Atualiza os dados de um produto. Digamos que temos o campo x, y e z. Se o user alterar apenas o x pra N, quando a query for executada no DB, as outras colunas continuaram as mesmas logo que o que o usuario enviou é o mesmo que está no DB. Isso evita a necessidade de criar funções pra alterar cada campo. Obrigado Renan.
        public function atualizarProduto($produtoID, $produtoNome, $produtoPreco, $produtoCategoria){
        //Sintaxe:                     Atualize em produtos os valores nome e etc                         Onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, categoria = :categoria WHERE id = :id");
            $query->bindValue(":id", $produtoID);
            $query->bindValue(":nome", $produtoNome);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria", $produtoCategoria);
            $query->execute();
        }

        // Delete

        // Deleta um produto, óbvio.
        public function removerProduto($produtoID){
        //Sintaxe =                       Delete Em  produtos onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $query->bindValue(":id", $produtoID);
            $query->execute();
        }

        // Compras
        // Ainda estou trabalhando nessa parte.
        public function adicionarVenda($produtoLista, $produtoTotal, $produtoVendedor){
            $query = $this->pdo->prepare("INSERT INTO produtos (produtos, total, vendedor) VALUES (:produtos, :total, :vendedor)");
            $query->bindValue(":produtos", $produtoLista);
            $query->bindValue(":total", $produtoTotal);
            $query->bindValue(":vendedor", $produtoVendedor);
            $query->execute();

        }

    }
?>