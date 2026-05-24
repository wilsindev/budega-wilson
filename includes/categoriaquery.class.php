<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once __DIR__ .  "/../config/conexao.php";
    class CategoriaQuery{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        // Adiciona uma categoria no DB.
        public function adicionarCategoria($categoriaName){
        try {
            $query = $this->pdo->prepare("INSERT INTO categorias (nome) VALUES (:nome)");
            $query->bindValue(":nome", $categoriaName);
            $query->execute();
            //retorna true pra nao dar erro lá no if
            return true;
        } 
        catch (PDOException $e) {
            if($e->getCode() == 23000){
                return false; // nome de categoria duplicado
            }
            //se o erro não for o 23000, ou seja, não for um erro de nome de categoria duplicado, deixa o erro estourar normalmente pra ser tratado em outro lugar ou mostrar uma mensagem de erro genérica.
            throw $e; // outro erro qualquer, deixa estourar na tela
        }
        }


        // Read
         
        //  Lista TODAS as categorias no DB
        // Pega as categorias que estão no DB.
        public function listarCategorias($limite, $offset){
            $query = $this->pdo->prepare("SELECT * FROM categorias LIMIT :limit OFFSET :offset");
            $query->bindValue(':limit', (int) $limite, PDO::PARAM_INT);
            $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $query->execute();
        //                 PegarTudoQueVeio em formato de objeto. PDO::FETCH_ASSOC também pode ser usado, retornando tudo em forma de"dicionário"  
            $categorias = $query->fetchAll(PDO::FETCH_OBJ);
            return $categorias;
        }
        public function getCategorias(){
            $query = $this->pdo->query("SELECT * FROM categorias ORDER BY nome");
            $categorias = $query->fetchAll(PDO::FETCH_OBJ);
            return $categorias;
        }
        public function buscarCategoriaPorNome($nome){
            $query = $this->pdo->prepare("SELECT * FROM categorias WHERE nome LIKE :nome");
            $query->bindValue(":nome", "%$nome%");
            $query->execute();
            $categoriasEncontradas = $query->fetchAll(PDO::FETCH_OBJ);
            return $categoriasEncontradas;
        }
        //Update
        // Atualiza os dados de uma categoria. Digamos que temos o campo x, y e z. Se o user alterar apenas o x pra N, quando a query for executada no DB, as outras colunas continuaram as mesmas logo que o que o usuario enviou é o mesmo que está no DB. Isso evita a necessidade de criar funções pra alterar cada campo. Obrigado Renan.
        public function atualizarCategoria($categoriaID, $categoriaName){
        //Sintaxe:                     Atualize em categorias os valores nome                         Onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("UPDATE categorias SET nome = :nome WHERE id = :id");
            $query->bindValue(":id", $categoriaID);
            $query->bindValue(":nome", $categoriaName);
            $query->execute();
        }

        // Delete

        // Deleta uma categoria, óbvio.
        public function removerCategoria($categoriaID){
        //Sintaxe =                       Delete Em  categorias onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("DELETE FROM categorias WHERE id = :id");
            $query->bindValue(":id", $categoriaID);
            $query->execute();
        }
    }
?>