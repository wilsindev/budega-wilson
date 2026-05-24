<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/produtoquery.class.php';
require_once __DIR__ . '/../includes/userquery.class.php';
require_once __DIR__ . '/../config/conexao.php';

$queryProduto = new ProdutoQuery($pdo);
$queryUser = new UserQuery($pdo);

// $totalProdutos = $queryProduto->contarProdutos();
// $totalCategorias = $queryProduto->contarCategorias();
// $totalUsuarios = $queryUser->contarUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <title>Budega do Wilson — Dashboard</title>
    <style>
        * { font-family: 'Geist', system-ui, sans-serif; }
        body { background-color: #f4f6f9; }

        .card {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06), 0 8px 24px rgba(15,23,42,0.05);
            animation: fadein 0.3s ease;
        }
        @keyframes fadein { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

        .divider { height: 1px; background: #e8ecf0; }

        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
    </style>
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
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <!-- Produtos -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Produtos</span>
                        <div class="stat-icon bg-indigo-50">
                            <i class="fa-solid fa-box text-indigo-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-[32px] font-semibold text-slate-800 leading-none">
                            1
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
                        <span class="text-[32px] font-semibold text-slate-800 leading-none">
                            2
                        </span>
                        <p class="text-[12px] text-slate-400 mt-1">categorias distintas</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_categorias/" class="text-[12px] text-emerald-500 hover:text-emerald-700 transition-colors flex items-center gap-1">
                        Ver categorias <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Usuários -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Usuários</span>
                        <div class="stat-icon bg-violet-50">
                            <i class="fa-solid fa-users text-violet-500 text-[14px]"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-[32px] font-semibold text-slate-800 leading-none">
                            3
                        </span>
                        <p class="text-[12px] text-slate-400 mt-1">usuários cadastrados</p>
                    </div>
                    <div class="divider"></div>
                    <a href="../pages_users/" class="text-[12px] text-violet-500 hover:text-violet-700 transition-colors flex items-center gap-1">
                        Ver usuários <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>
    </main>
</body>
</html>