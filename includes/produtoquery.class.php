<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once __DIR__ .  "/../config/conexao.php";
    class ProdutoQuery{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        // Adiciona um produto qualquer no DB. 
        // faltar colocar quantidade. 
        // fazer sistema de paginação com filtro
        public function adicionarProduto($produtoName, $produtoPreco, $produtoCategoria){
        //                                Inserir Na   Tabela     Colunas da tabela   Valores  Aqui são os placeholders que vão ser substituidos.
            $query = $this->pdo->prepare("INSERT INTO produtos (nome, preco, categoria_id) VALUES (:nome, :preco, :categoria_id)");
        //                  Placeholder  Variavel que vai substituir o placeholder.
            $query->bindValue(":nome", $produtoName);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria_id", $produtoCategoria);
        // Executa sua query.  
            $query->execute();
        }


        // Read
        // Pega apenas um produto e seus dados no DB  usando seu ID que é único.
        //usado no editar.php para preencher os campos com os dados atuais do produto.
        public function getDadosProdutos($produtoId){
        //Sintaxe                    Selecionar Tudo Da Tabela  Onde o id no DB seja igual ao id inserido pelo user.
            $query = $this->pdo->prepare("SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON p.categoria_id = c.id WHERE p.id = :id");
            $query->bindValue(":id", $produtoId);
            $query->execute();
            $produto = $query->fetch(PDO::FETCH_OBJ);
            return $produto;
        }

        public function contarProdutos(){
            $query = $this->pdo->query("SELECT COUNT(*) AS total FROM produtos");
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total;
        }
        //  Lista TODOS os produtos no DB
        public function listarProdutos($limite, $offset){
        //Sintaxe                  Selecionar Tudo Da Tabela  Com Limite x Pulando de x em x a cada execute.
        // OFFSET pula de x em x em busca de não repetir os anteriores.
            $query = $this->pdo->prepare("SELECT p.*, c.nome AS categoria 
        FROM produtos p
        JOIN categorias c ON p.categoria_id = c.id
        LIMIT :limit OFFSET :offset");
            $query->bindValue(':limit', (int) $limite, PDO::PARAM_INT);
            $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $query->execute();
        //                 PegarTudoQueVeio em formato de objeto. PDO::FETCH_ASSOC também pode ser usado, retornando tudo em forma de"dicionário"  
            $produtos = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtos;
        }

        // Filtra os produtos por categoria 
        public function filtrarProdutosCategoria($filtro){
        //Sintaxe                    Selecionar Tudo Da Tabela  Onde  categoria no DB seja igual a categoria inserida pelo user
            $query = $this->pdo->prepare("SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON p.categoria_id = c.id 
            WHERE c.id = :categoria");
            $query->bindValue(":categoria", $filtro);
            $query->execute();
            $produtosFiltrados = $query->fetchAll(PDO::FETCH_OBJ);
            return $produtosFiltrados;
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


        //Update
        // Atualiza os dados de um produto. Digamos que temos o campo x, y e z. Se o user alterar apenas o x pra N, quando a query for executada no DB, as outras colunas continuaram as mesmas logo que o que o usuario enviou é o mesmo que está no DB. Isso evita a necessidade de criar funções pra alterar cada campo. Obrigado Renan.
        public function atualizarProduto($produtoID, $produtoNome, $produtoPreco, $produtoCategoria){
        //Sintaxe:                     Atualize em produtos os valores nome e etc                         Onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, categoria_id = :categoria_id WHERE id = :id");
            $query->bindValue(":id", $produtoID);
            $query->bindValue(":nome", $produtoNome);
            $query->bindValue(":preco", $produtoPreco);
            $query->bindValue(":categoria_id", $produtoCategoria);
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
    }
?>