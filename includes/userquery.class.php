<?php  
    // DB = DataBase
    // Placeholders = são "espaços em branco", que vão ser preenchidos pelas variaveis em si durante o bindValue ou bindParam.
    require_once __DIR__ .  "/../config/conexao.php";
    class UserQuery{
        private $pdo;
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        // Create
        // Adiciona um produto qualquer no DB. 
        // faltar colocar quantidade. 
        // fazer sistema de paginação com filtro
        public function salvarUser($userName, $userEmail, $userPassword, $userIsAdmin){
        //                                Inserir Na   Tabela     Colunas da tabela   Valores  Aqui são     
        try {
            $query = $this->pdo->prepare("INSERT INTO users (nome, email, senha, is_admin) VALUES (:nome, :email, :senha, :is_admin)");
            $senha_hashada = password_hash($userPassword, PASSWORD_DEFAULT);
            $query->bindValue(":nome", $userName);
            $query->bindValue(":email", $userEmail);
            $query->bindValue(":senha", $senha_hashada);
            $query->bindValue(":is_admin", $userIsAdmin); // Por padrão, novo usuário não é administrador
            $query->execute();
            //retorna true pra nao dar erro lá no if
            return true;
        } 
        catch (PDOException $e) {
            if($e->getCode() == 23000){
                return false; // email duplicado
            }
            //se o erro não for o 23000, ou seja, não for um erro de email duplicado, deixa o erro estourar normalmente pra ser tratado em outro lugar ou mostrar uma mensagem de erro genérica.
            throw $e; // outro erro qualquer, deixa estourar na tela
        }
        }


        // Read
        public function contarUsers(){
            $query = $this->pdo->query("SELECT COUNT(*) AS total FROM users");
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total;
        }
        public function logarUser($userEmail, $userPassword){
            $query = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $query->bindvalue(":email", $userEmail);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
            //se existir um user com esse email e a senha inserida for igual a senha do DB, retorna o user, senão retorna false. O password_verify é usado para comparar a senha inserida com a senha hashada do DB.
            if($user && password_verify($userPassword, $user->senha)){
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->nome;
                $_SESSION['is_admin'] = $user->is_admin;
                return true;
            } else {
                return false;
            }
        }

        public function getDadosUser($userId){
            $query = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $query->bindValue(":id", $userId);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_OBJ);
            return $user;
        }

        //Update
        // Atualiza os dados de um produto. Digamos que temos o campo x, y e z. Se o user alterar apenas o x pra N, quando a query for executada no DB, as outras colunas continuaram as mesmas logo que o que o usuario enviou é o mesmo que está no DB. Isso evita a necessidade de criar funções pra alterar cada campo. Obrigado Renan.
        public function atualizarUser($userId, $userName, $userEmail){
        //Sintaxe:                     Atualize em users os valores nome e email                         Onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("UPDATE users SET nome = :nome, email = :email WHERE id = :id");
            $query->bindValue(":id", $userId);
            $query->bindValue(":nome", $userName);
            $query->bindValue(":email", $userEmail);
            $query->execute();
        }

        // Delete

        // Deleta um user, óbvio.
        public function removerUser($userId){
        //Sintaxe =                       Delete Em  produtos onde id no DB seja igual a id inserido.
            $query = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $query->bindValue(":id", $userId);
            $query->execute();
        }
    }
?>