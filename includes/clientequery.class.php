<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once __DIR__ .  "/../config/conexao.php";
    class ClienteQuery{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        // Adiciona uma categoria no DB.
        public function adicionarCliente($clienteName, $clienteCPF, $clienteTelefone){
        // try {
            $query = $this->pdo->prepare("INSERT INTO clientes (nome, cpf, telefone) VALUES (:nome, :cpf, :telefone)");
            $query->bindValue(":nome", $clienteName);
            $query->bindValue(":cpf", $clienteCPF);
            $query->bindValue(":telefone", $clienteTelefone);
            $query->execute();
            //retorna true pra nao dar erro lá no if
            return true;
        } 
        // catch (PDOException $e) {
        //     if($e->getCode() == 23000){
        //         return false; // nome de categoria duplicado
        //     }
        //     //se o erro não for o 23000, ou seja, não for um erro de nome de categoria duplicado, deixa o erro estourar normalmente pra ser tratado em outro lugar ou mostrar uma mensagem de erro genérica.
        //     throw $e; // outro erro qualquer, deixa estourar na tela
        // }


        // Read
        public function getDadosClientes($clienteId){
            $query = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
            $query->bindValue(":id", $clienteId);
            $query->execute();
            $cliente = $query->fetch(PDO::FETCH_OBJ);
            return $cliente;
        }
        public function contarClientes(){
            $query = $this->pdo->query("SELECT COUNT(*) AS total FROM clientes");
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total;
        }
        //  Lista TODOS os clientes no DB
        // Pega os clientes que estão no DB.
        public function listarClientes($limite, $offset){
            $query = $this->pdo->prepare("SELECT * FROM clientes LIMIT :limit OFFSET :offset");
            $query->bindValue(':limit', (int) $limite, PDO::PARAM_INT);
            $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $query->execute();
        //                 PegarTudoQueVeio em formato de objeto. PDO::FETCH_ASSOC também pode ser usado, retornando tudo em forma de"dicionário"  
            $clientes = $query->fetchAll(PDO::FETCH_OBJ);
            return $clientes;
        }
        public function buscarClientePorNome($nome){
            $query = $this->pdo->prepare("SELECT * FROM clientes WHERE nome LIKE :nome");
            $query->bindValue(":nome", "%$nome%");
            $query->execute();
            $clientesEncontrados = $query->fetchAll(PDO::FETCH_OBJ);
            return $clientesEncontrados;
        }
        //Update
        // Atualiza os dados de uma categoria. Digamos que temos o campo x, y e z. Se o user alterar apenas o x pra N, quando a query for executada no DB, as outras colunas continuaram as mesmas logo que o que o usuario enviou é o mesmo que está no DB. Isso evita a necessidade de criar funções pra alterar cada campo. Obrigado Renan.
        public function atualizarCliente($clienteID, $clienteName, $clienteCPF, $clienteTelefone){
        //Sintaxe:                     Atualize em clientes os valores nome                         Onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone WHERE id = :id");
            $query->bindValue(":id", $clienteID);
            $query->bindValue(":nome", $clienteName);
            $query->bindValue(":cpf", $clienteCPF);
            $query->bindValue(":telefone", $clienteTelefone);
            $query->execute();
        }

        // Delete

        // Deleta um cliente, óbvio.
        public function removerCliente($clienteID){
        //Sintaxe =                       Delete Em  clientes onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
            $query->bindValue(":id", $clienteID);
            $query->execute();
        }
    }
?>