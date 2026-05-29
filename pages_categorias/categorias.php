<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
// __DIR__ Retorna a pasta do arquivo atual.
    require_once __DIR__ . '/../includes/categoriaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $page = $_GET['pagina'] ?? 1;
    $limitPerPage = 5;
    $offset = ($page - 1) * $limitPerPage;
    $query = new CategoriaQuery($pdo);
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
    <title>Loja do Wilson - Categorias</title>
    <style>
        * { font-family: 'Geist', system-ui, sans-serif; }
        code, .mono { font-family: 'Geist Mono', monospace; }


        main { position: relative; z-index: 1; }

        /* Card */
        .card-glow {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            box-shadow:
                0 1px 3px rgba(15,23,42,0.06),
                0 8px 24px rgba(15,23,42,0.05);
        }

        /* Header text */
        .brand-text {
            color: #1e293b;
        }

        /* Table row hover */
        tr.data-row { transition: background 0.12s ease; }
        tr.data-row:hover { background: #f0f4ff; }
        tr.data-row:hover td:first-child { border-left: 2px solid #818cf8; padding-left: 14px; }
        tr.data-row td:first-child { border-left: 2px solid transparent; transition: border-color 0.12s, padding 0.12s; }

        /* Input focus ring */
        .field:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.15);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #e8ecf0;
        }

        /* Btn add */
        .btn-add {
            background: #4f46e5;
            box-shadow: 0 1px 3px rgba(79,70,229,0.25), 0 1px 0 rgba(255,255,255,0.1) inset;
            transition: filter 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-add:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }
        .btn-add:active { transform: translateY(0); }

        /* Secondary button */
        .btn-secondary {
            background: #ffffff;
            border: 1px solid #dde2e8;
            color: #64748b;
            transition: background 0.12s, border-color 0.12s, color 0.12s;
        }
        .btn-secondary:hover {
            background: #eef0fe;
            border-color: #818cf8;
            color: #4f46e5;
        }

        /* Delete/Edit action buttons */
        .action-del {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #ef4444;
            transition: all 0.12s;
        }
        .action-del:hover {
            background: #fee2e2;
            border-color: #f87171;
            color: #dc2626;
        }

        .action-edit {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #d97706;
            transition: all 0.12s;
        }
        .action-edit:hover {
            background: #fef3c7;
            border-color: #fbbf24;
            color: #b45309;
        }

        /* Pagination */
        .page-current {
            background: #4f46e5;
            color: #fff;
            box-shadow: 0 2px 6px rgba(79,70,229,0.3);
        }
        .page-btn {
            background: #ffffff;
            border: 1px solid #dde2e8;
            color: #64748b;
            transition: all 0.12s;
        }
        .page-btn:hover {
            background: #eef0fe;
            border-color: #818cf8;
            color: #4f46e5;
        }

        /* Category badge */
        .badge-cat {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            
        }

        /* ID badge */
        .badge-id {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        /* Price */
        .price-val { color: #059669; }

        /* TH */
        thead th {
            background: #f8fafc;
            font-size: 10px;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 1px solid #e8ecf0;
        }

        /* Logo dot */
        .logo-dot {
            width: 8px; height: 8px;
            background: #4f46e5;
            border-radius: 50%;
            box-shadow: 0 0 0 3px #e0e7ff;
        }

        /* Fade-in on load */
        .card-glow { animation: fadein 0.3s ease; }
        @keyframes fadein { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

        /* Select arrow override */
        select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none'%3E%3Cpath d='M2.5 4.5L6 8l3.5-3.5' stroke='%2394a3b8' stroke-width='1.4' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px !important; }

        /* Table border */
        .table-wrap { border: 1px solid #e8ecf0; }
        tr.data-row { border-top: 1px solid #f1f5f9; }

        /* Page info text */
        .page-info { color: #94a3b8; }

        /* Subtitle text */
        .subtitle { color: #94a3b8; }
        #user-menu a:hover {
            background: #eef0fe;
            color: #4f46e5;
        }

        #user-menu a.sair:hover {
            background: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="card-glow rounded-2xl p-8 w-full max-w-[800px] flex flex-col gap-7">
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
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[11px] pointer-events-none"></i>
                        <input type="text" name="q"
                               class="field bg-white border border-slate-200 text-[#060606] placeholder-slate-400 text-[13px] rounded-lg pl-8 pr-3 py-2 w-52"
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
                                    <?php echo $categoriaAchada->categoria ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <a href="excluir.php?id=<?php echo $categoriaAchada->id ?>"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </a>
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
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <a href="excluir.php?id=<?php echo $categoria->id ?>"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </a>
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
                    <a href="index.php?pagina=<?php echo $page - 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                    <span class="page-current flex justify-center items-center w-8 h-8 rounded-lg text-white text-[13px] font-semibold">
                        <?php echo $page ?>
                    </span>
                    <a href="index.php?pagina=<?php echo $page + 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>
</body>
</html>