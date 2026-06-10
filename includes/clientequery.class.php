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
            $query = $this->pdo->prepare("INSERT INTO clientes (nome, cpf, telefone) VALUES (:nome, :cpf, :telefone)");
            $query->bindValue(":nome", $clienteName);
            $query->bindValue(":cpf", $clienteCPF);
            $query->bindValue(":telefone", $clienteTelefone);
            $query->execute();
            //retorna true pra nao dar erro lá no if
            return true;
        } 


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
        public function removerCliente($clienteID){
            $query = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
            $query->bindValue(":id", $clienteID);
            $query->execute();
            return true;
        }
    }
?>