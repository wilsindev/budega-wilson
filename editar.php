<?php 
    $produtoId = $_GET['id'];
    require_once "query.class.php";
    require_once "conexao.php";
    $query = new Query($pdo);
    $produto = $query->getDadosProdutos($produtoId);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query->atualizarProduto(
        $produtoId,
        $_POST['nome'],
        $_POST['preco'],
        $_POST['categoria']
    );
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Budega do Wilson - Editar produto</title>
</head>
<body class="text-black w-screen h-screen">
    <main class="flex flex-col justify-center items-center w-screen h-screen">
    <h2 class="text-xl font-bold mb-4">Edição de Produto</h2>
    <div class="bg-[#5489ee] shadow-lg rounded-2xl p-6 w-[1000px] ">
        <form action="" method="post" class="flex  justify-center items-center gap-4">
                <label for="nome" class="text-white">Nome: </label>
                <input type="text" id="nome" name="nome" value="<?php echo $produto->nome?>" required class="bg-white  rounded-md p-2">
                <label for="categoria" class="text-white">Categoria: </label>
                <input type="text" id="categoria" name="categoria" value="<?php echo $produto->categoria?>" required class="bg-white  rounded-md p-2">
                <label for="preco" class="text-white">Preço: </label>
                <input type="number" id="preco" name="preco" step="0.01" value="<?php echo $produto->preco ?>" required class="bg-white rounded-md p-2">
                <input type="submit" value="Editar" class="bg-green-500 cursor-pointer text-white rounded-md p-2 hover:scale-110 transition duration-300">
            </form>
            <div class="w-20 h-10   bg-red-600 text-white p-2 flex justify-center items-center rounded-lg ml-10 mt-20 hover:scale-110 transition duration-300">
                <a href="produtos.php">Cancelar</a>
            </div>
    </div>
    </main>
</body>
</html>