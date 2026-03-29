<?php 
    require_once "query.class.php";
    require_once "conexao.php";
    $query = new Query($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Budega do Wilson</title>
</head>
<body class="text-black w-full h-screen">
    <main class="flex flex-col items-center w-full min-h-screen py-10">
    <h2 class="text-xl font-bold mb-4">Lista de Produtos</h2>
    <div class="bg-[#5489ee] flex flex-col shadow-lg rounded-2xl p-6 w-[700px] gap-2">
    
        <h2 class="text-xl text-white font-bold mb-4">Produtos</h2>
        <div class=" w-40 h-10 bg-white text-black rounded-md p-4 flex justify-center items-center  text-sm ">
            <a href="insert.php">Adicionar produto</a>
        </div>
        <form action="" method="post">
                <select name="filtrar" id="filtrar" class="bg-white text-black rounded-md p-4">
                    <option value="" selected disabled>Filtrar</option>
                    <?php 
                        $categorias = $query->listarCategorias();
                        foreach($categorias as $categoria){
                        
                    ?>
                    <option value="<?php echo $categoria->categoria ?>"><?= $categoria->categoria ?></option>
                    <?php }?>
                </select>
                <button type="submit" class="bg-white text-black rounded-md p-4"><i class="fa-solid fa-arrows-rotate"></i></button>
        </form>
        <table class="w-full">
        <thead>
            <tr class="bg-white text-left">
            <th class="p-3">ID</th>
            <th class="p-3">Nome</th>
            <th class="p-3">Preço</th>
            <th class="p-3">Categoria</th>
            <th class="p-3">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(!empty($_POST['filtrar'])){
                    $filtro = $_POST['filtrar'];
                    $produtosFiltrados = $query->filtrarProdutosCategoria($filtro);
                    foreach($produtosFiltrados as $produtoFiltrado){     
                    ?>
            <tr class="border-b bg-white hover:bg-gray-100">
            <td class="p-3"><?php echo $produtoFiltrado->id?></td>
            <td class="p-3"><?php echo $produtoFiltrado->nome?></td>
            <td class="p-3">R$ <?php echo $produtoFiltrado->preco?></td>
            <td class="p-3"><?php echo $produtoFiltrado->categoria?></td>
            <td class="p-3 flex align-center justify-center gap-2"><a href="excluir.php?id=<?php echo $produtoFiltrado->id ?>" class=" bg-red-600 text-white p-2 rounded-md">Excluir</a><a href="editar.php?id=<?php echo $produtoFiltrado->id ?>" class=" bg-yellow-500 text-white p-2 rounded-md ">Editar</a></td>
            </tr>
            <?php }}?>

            <?php 
                if(!isset($_POST['filtrar'])){
                    $produtos = $query->listarProdutos();
                    foreach($produtos as $produto){

            ?>
            <tr class="border-b bg-white hover:bg-gray-100">
            <td class="p-3"><?php echo $produto->id?></td>
            <td class="p-3"><?php echo $produto->nome?></td>
            <td class="p-3">R$ <?php echo $produto->preco?></td>
            <td class="p-3"><?php echo $produto->categoria?></td>
            <td class="p-3 flex align-center justify-center gap-2"><a href="excluir.php?id=<?php echo $produto->id ?>" class=" bg-red-600 text-white p-2 rounded-md">Excluir</a><a href="editar.php?id=<?php echo $produto->id ?>" class=" bg-yellow-500 text-white p-2 rounded-md ">Editar</a></td>
            </tr>
            <?php }}?>
        </tbody>
        </table>
    </div>
    </main>
</body>
</html>