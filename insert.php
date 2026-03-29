<?php
        require_once "query.class.php";
        require_once "conexao.php";
        if (isset($_POST['nome']) && isset($_POST['categoria']) && isset($_POST['preco'])){
            $query = new Query($pdo);
            $produtoNome = $_POST['nome'];
            $produtoCategoria = $_POST['categoria'];
            $produtoPreco = $_POST['preco'];
            $query->adicionarProduto($produtoNome, $produtoPreco, $produtoCategoria);
            header("Location: produtos.php");
            exit;
        }
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Budega do Wilson</title>
</head>
<body class="text-black w-screen h-screen">
    <main class="flex flex-col justify-center items-center w-screen h-screen">
        <h1 class="text-black text-4xl mb-4">Cadastro produtos</h1>
        <div class="bg-[#5489ee] shadow-lg rounded-2xl p-6 w-[1000px]">
            <form action="" method="post" class="flex  justify-center items-center gap-4">
                <label for="nome" class="text-white">Nome: </label>
                <input type="text" id="nome" name="nome" required class="bg-white text-black rounded-md p-2">
                <label for="categoria" class="text-white">Categoria: </label>
                <input type="text" id="categoria" name="categoria" required class="bg-white text-black rounded-md p-2">
                <label for="preco" class="text-white">Preço: </label>
                <input type="number" id="preco" name="preco" step="0.01" required class="bg-white text-black rounded-md p-2">
                <input type="submit" value="Cadastrar" class="bg-white rounded-md p-2">
            </form>
            <div class="w-20 h-10  bg-white flex justify-center items-center rounded-lg ml-10 mt-20">
                <a href="produtos.php">Voltar</a>
            </div>
        </div>
    </main>
</body>
</html>