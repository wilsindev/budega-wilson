<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/produtoquery.class.php';
require_once __DIR__ . '/../includes/clientequery.class.php';
require_once __DIR__ . '/../includes/categoriaquery.class.php';
require_once __DIR__ . '/../includes/vendaquery.class.php';
require_once __DIR__ . '/../config/conexao.php';

$queryProduto = new ProdutoQuery($pdo);
$queryCliente = new ClienteQuery($pdo);
$queryCategoria = new CategoriaQuery($pdo);
$queryVenda = new VendaQuery($pdo);
$totalProdutos = $queryProduto->contarProdutos();
$totalCategorias = $queryCategoria->contarCategorias();
$totalClientes = $queryCliente->contarClientes();
$totalVendas = $queryVenda->totalVendas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/counter.js" defer></script>
    <link rel="icon" type="image/x-icon" href="../assets/logobudegafav.png">
    <title>Loja do Wilson — Dashboard</title>

</head>
<body class="text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="w-full max-w-[800px] flex flex-col gap-7">

            <!-- Título -->
            <div>
                <h2 class="text-[17px] font-semibold text-slate-800">Dashboard</h2>
                <p class="text-[13px] text-slate-400 mt-0.5">Visão geral da loja</p>
            </div>

            <!-- Cards de estatísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

                <!-- Produtos -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Produtos</span>
                        <div class="stat-icon bg-indigo-50">
                            <i class="fa-solid fa-box text-indigo-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="counter text-[30px] font-semibold text-slate-800 leading-none" data-target="<?php echo htmlspecialchars($totalProdutos); ?>">
                            0
                        </span>
                        <p class="text-[12px] text-slate-400 mt-1">cadastrados no sistema</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_produtos/produtos.php" class="text-[12px] text-indigo-500 hover:text-indigo-700 transition-colors flex items-center gap-1">
                        Ver produtos <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Categorias -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Categorias</span>
                        <div class="stat-icon bg-emerald-50">
                            <i class="fa-solid fa-tag text-emerald-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-[30px] font-semibold text-slate-800 leading-none counter" data-target=" <?= htmlspecialchars($totalCategorias) ?>">
                            0
                        </span>
                        <p class="text-[12px] text-slate-400 mt-1">categorias distintas</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_categorias/categorias.php" class="text-[12px] text-emerald-500 hover:text-emerald-700 transition-colors flex items-center gap-1">
                        Ver categorias <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Clientes -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Clientes</span>
                        <div class="stat-icon bg-violet-50">
                            <i class="fa-solid fa-users text-violet-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="counter text-[32px] font-semibold text-slate-800 leading-none" data-target="<?php echo htmlspecialchars($totalClientes); ?>">
                            0
                        </span>
                        <p class="text-[12px] text-slate-400 mt-1">clientes cadastrados</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_clientes/clientes.php" class="text-[12px] text-violet-500 hover:text-violet-700 transition-colors flex items-center gap-1">
                        Ver clientes <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <!-- Vendas -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Total</span>
                        <div class="stat-icon bg-violet-50">
                            <i class="fa-solid fa-money-bill text-pink-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="counter text-[25px] font-semibold text-slate-800 leading-none" data-target="<?php echo htmlspecialchars($totalVendas); ?>" data-decimal="true">
                            0
                        </span>
                        <span class="text-[25px] font-semibold text-slate-800 leading-none"> R$</span>
                        <p class="text-[12px] text-slate-400 mt-1">de lucro</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_vendas/vendas.php" class="text-[12px] text-pink-500 hover:text-pink-700 transition-colors flex items-center gap-1">
                        Ver vendas <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>
            <div class="flex  justify-around gap-2">
                <a href="insert.php" class="group relative h-20 w-40 bg-white border border-slate-200 hover:border-indigo-400 rounded-2xl overflow-hidden flex flex-row transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute top-0 left-0 right-0 h-[2px] bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-1/2 flex-shrink-0 flex items-center justify-center bg-indigo-50">
                        <i class="fa-solid fa-plus text-indigo-500 text-[13px]"></i>
                    </div>
                    <div class="w-1/2 flex flex-col justify-center px-3">
                        <span class="text-[9px] text-slate-400 tracking-[0.15em] uppercase">Novo</span>
                        <span class="text-[12px] text-slate-700 font-medium">Produto</span>
                    </div>
                </a>
                <a href="../pages_categorias/create.php" class="group relative h-20 w-40 bg-white border border-slate-200 hover:border-emerald-400 rounded-2xl overflow-hidden flex flex-row transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute top-0 left-0 right-0 h-[2px] bg-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-1/2 flex-shrink-0 flex items-center justify-center bg-emerald-50">
                        <i class="fa-solid fa-plus text-emerald-500 text-[13px]"></i>
                    </div>
                    <div class="w-1/2 flex flex-col justify-center px-3">
                        <span class="text-[9px] text-slate-400 tracking-[0.15em] uppercase">Nova</span>
                        <span class="text-[12px] text-slate-700 font-medium">Categoria</span>
                    </div>
                </a>
                <a href="../pages_clientes/create.php" class="group relative h-20 w-40 bg-white border border-slate-200 hover:border-violet-400 rounded-2xl overflow-hidden flex flex-row transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute top-0 left-0 right-0 h-[2px] bg-violet-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-1/2 flex-shrink-0 flex items-center justify-center bg-violet-50">
                        <i class="fa-solid fa-plus text-violet-500 text-[13px]"></i>
                    </div>
                    <div class="w-1/2 flex flex-col justify-center px-3">
                        <span class="text-[9px] text-slate-400 tracking-[0.15em] uppercase">Novo</span>
                        <span class="text-[12px] text-slate-700 font-medium">Cliente</span>
                    </div>
                </a>
                <a href="../pages_vendas/nova_venda.php" class="group relative h-20 w-40 bg-white border border-slate-200 hover:border-pink-400 rounded-2xl overflow-hidden flex flex-row transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute top-0 left-0 right-0 h-[2px] bg-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-1/2 flex-shrink-0 flex items-center justify-center bg-violet-50">
                        <i class="fa-solid fa-plus text-pink-500 text-[13px]"></i>
                    </div>
                    <div class="w-1/2 flex flex-col justify-center px-3">
                        <span class="text-[9px] text-slate-400 tracking-[0.15em] uppercase">Nova</span>
                        <span class="text-[12px] text-slate-700 font-medium">Venda</span>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>