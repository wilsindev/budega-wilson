<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
// __DIR__ Retorna a pasta do arquivo atual.
    require_once __DIR__ . '/../includes/categoriaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $page = $_GET['pagina'] ?? 1;
    $limitPerPage = 10;
    $offset = ($page - 1) * $limitPerPage;
    $query = new CategoriaQuery($pdo);
    $totalCategorias = $query->contarCategorias();
    $totalPages = ceil($totalCategorias / $limitPerPage);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/logobudegafav.png">
    <script src="../js/modal.js" defer></script>
    <link rel="stylesheet" href="../css/index.css">
    <title>Loja do Wilson - Categorias</title>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="card-glow rounded-2xl p-8 w-full max-w-[800px] flex flex-col gap-7">
            <?php if (isset($_GET['error']) && $_GET['error'] === '23000'): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Não é possível excluir esta categoria porque ela está associada a um produto. Por favor, remova ou altere os produtos associados antes de excluir esta categoria.</span>
                </div>
            <?php endif; ?>
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-[17px] font-semibold brand-text leading-tight">Categorias</h2>
                    </div>
                </div>
                <a href="create.php"
                   class="btn-add flex items-center gap-2 text-white text-[13px] font-medium px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    Adicionar categoria
                </a>
            </div>

            <div class="divider"></div>

            <!-- Controles -->
            <div class="flex flex-wrap gap-2.5">
                <form action="" method="get" class="flex gap-2 items-center">
                    <div class="flex items-center bg-white border border-slate-200 rounded-lg px-3 gap-2 w-52">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-[11px] pointer-events-none"></i>
                        <input type="text" name="q"
                            class="bg-transparent text-[#060606] placeholder-slate-400 text-[13px] py-2 outline-none w-full"
                            placeholder="Pesquisar por nome…">
                    </div>
                    <button type="submit" class="btn-secondary flex items-center justify-center w-9 h-9 rounded-lg cursor-pointer">
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </button>
                </form>
            </div>

            <!-- Tabela -->
            <div class="table-wrap rounded-xl overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-[#060606]">Nome</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Produtos</th>
                            <th class="px-4 py-3 text-center w-28 text-[#060606]">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($_GET['q'])):
                            $nome = $_GET['q'];
                            $categoriasAchadas = $query->buscarCategoriaPorNome($nome);
                            foreach($categoriasAchadas as $categoriaAchada): ?>
                        <tr class="data-row border-t border-slate-100">
                            <td class="px-4 py-3.5 text-[13px] text-slate-700 font-normal"><?php echo $categoriaAchada->nome ?></td>
                            <td class="px-4 py-3.5">
                                <span class="badge-cat rounded-full px-2.5 py-0.5 text-[11px]  font-medium">
                                    <?php echo $query->contarProdutosPorCategoria($categoriaAchada->id) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <button onclick="abrirModal('produto', '<?php echo $categoriaAchada->nome ?>', 'excluir.php?id=<?php echo $categoriaAchada->id ?>')"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </button>
                                    <a href="editar.php?id=<?php echo $categoriaAchada->id ?>"
                                       class="action-edit text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-pen mr-1 text-[9px]"></i>Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>

                        <?php if(empty($_GET['filtrar']) && empty($_GET['q'])):
                            $categorias = $query->listarCategorias($limitPerPage, $offset);
                            foreach($categorias as $categoria): ?>
                        <tr class="data-row border-t border-slate-100">
                            <td class="px-4 py-3.5 text-[13px] text-[#060606] font-normal"><?php echo $categoria->nome ?></td>
                            <td class="px-4 py-3.5 text-[13px] text-[#060606] font-normal">
                                <span class="badge-cat rounded-full px-2.5 py-0.5 text-[11px]  font-medium">
                                        <?php echo $query->contarProdutosPorCategoria($categoria->id) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <button onclick="abrirModal('categoria', '<?php echo $categoria->nome ?>', 'excluir.php?id=<?php echo $categoria->id ?>')"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </button>
                                    <a href="editar.php?id=<?php echo $categoria->id ?>"
                                       class="action-edit text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-pen mr-1 text-[9px]"></i>Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>

                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="flex justify-between items-center">
                <span class="text-[11px] page-info">Página <?php echo $page ?></span>
                <div class="flex gap-1.5">
                    <?php if ($page - 1 > 0): ?>
                    <a href="categorias.php?pagina=<?php echo $page - 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                    <span class="page-current flex justify-center items-center w-8 h-8 rounded-lg text-white text-[13px] font-semibold">
                        <?php echo $page ?>
                    </span>
                    <?php if ($page < $totalPages): ?>
                    <a href="categorias.php?pagina=<?php echo $page + 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>
    <div id="modal-overlay" class="hidden fixed inset-0 bg-slate-900/35 z-50 items-center justify-center">
        <div class="bg-white border border-slate-200 rounded-2xl p-7 w-full max-w-sm font-sans">
            <div class="w-10 h-10 bg-red-50 border border-red-200 rounded-xl flex items-center justify-center text-red-500 mb-3.5">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <p id="modal-title" class="text-[15px] font-semibold text-slate-800 mb-1.5"></p>
            <p id="modal-desc" class="text-[13px] text-slate-500 mb-5 leading-relaxed"></p>
            <div class="flex gap-2 justify-end">
                <button onclick="fecharModal()" class="bg-white border border-slate-200 text-slate-500 text-[13px] font-medium px-4 py-2 rounded-lg cursor-pointer">Voltar</button>
                <a id="modal-confirm-link" href="#" class="bg-red-500 text-white text-[13px] font-medium px-4 py-2 rounded-lg no-underline">Excluir categoria</a>
            </div>
        </div>
    </div>
</body>
</html>