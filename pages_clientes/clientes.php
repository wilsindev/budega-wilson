<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
// __DIR__ Retorna a pasta do arquivo atual.
    require_once __DIR__ . '/../includes/clientequery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $page = $_GET['pagina'] ?? 1;
    $limitPerPage = 10;
    $offset = ($page - 1) * $limitPerPage;
    $query = new ClienteQuery($pdo);
    $totalClientes = $query->contarClientes();
    $totalPages = ceil($totalClientes / $limitPerPage);
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../js/select.js" defer></script>
    <script src="../js/modal.js" defer></script>
    <link rel="stylesheet" href="../css/index.css">
    <title>Loja do Wilson - Clientes</title>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="card-glow rounded-2xl p-8 w-full max-w-[800px] flex flex-col gap-7">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-[17px] font-semibold brand-text leading-tight">Clientes</h2>
                    </div>
                </div>
                <a href="create.php"
                   class="btn-add flex items-center gap-2 text-white text-[13px] font-medium px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    Adicionar cliente
                </a>
            </div>

            <div class="divider"></div>

            <!-- Controles !-->
            <div class="flex justify-between flex-wrap gap-2.5">
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
                            <th class="px-4 py-3 text-left w-28 text-[#060606]">Cpf</th>
                            <th class="px-4 py-3 text-left w-32 text-[#060606]">Telefone</th>
                            <?php if($_SESSION['is_admin'] === 1): ?>
                                <th class="px-4 py-3 text-center w-28 text-[#060606]">Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(!empty($_GET['q'])):
                            $pesquisa = $_GET['q'];
                            $clientesAchados = $query->buscarClientePorNome($pesquisa);
                            foreach($clientesAchados as $clienteAchado): ?>
                        <tr class="data-row border-t border-slate-100">
                            <td class="px-4 py-3.5 text-[13px] text-slate-700 font-normal"><?php echo htmlspecialchars($clienteAchado->nome) ?></td>
                            <td class="px-4 py-3.5 text-[13px] price-val font-medium mono whitespace-nowrap"><?php echo htmlspecialchars($clienteAchado->cpf) ?></td>
                            <td class="px-4 py-3.5 text-[13px] price-val font-medium mono whitespace-nowrap"><?php echo htmlspecialchars($clienteAchado->telefone) ?></td>
                            <?php if($_SESSION['is_admin'] === 1): ?>
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <button onclick="abrirModal('cliente', '<?php echo addslashes(htmlspecialchars($clienteAchado->nome)) ?>', 'excluir.php?id=<?php echo $clienteAchado->id ?>')"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </button>
                                    <a href="editar.php?id=<?php echo $clienteAchado->id ?>"
                                    class="action-edit text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-pen mr-1 text-[9px]"></i>Editar
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; endif; ?>

                        <?php if(empty($_GET['q'])):
                            $clientes = $query->listarClientes($limitPerPage, $offset);
                            foreach($clientes as $cliente): ?>
                        <tr class="data-row border-t border-slate-100">
                            <td class="px-4 py-3.5 text-[13px] text-slate-700 font-normal"><?php echo htmlspecialchars($cliente->nome) ?></td>
                            <td class="px-4 py-3.5 text-[13px] price-val font-medium mono whitespace-nowrap"><?php echo htmlspecialchars($cliente->cpf) ?></td>
                            <td class="px-4 py-3.5 text-[13px] price-val font-medium mono whitespace-nowrap"><?php echo htmlspecialchars($cliente->telefone) ?></td>
                            <?php if($_SESSION['is_admin'] === 1): ?>
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <button onclick="abrirModal('cliente', '<?php echo addslashes(htmlspecialchars($cliente->nome)) ?>', 'excluir.php?id=<?php echo $cliente->id ?>')"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Excluir
                                    </button>
                                    <a href="editar.php?id=<?php echo $cliente->id ?>"
                                    class="action-edit text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-pen mr-1 text-[9px]"></i>Editar
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
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
                    <a href="clientes.php?pagina=<?php echo $page - 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                    <span class="page-current flex justify-center items-center w-8 h-8 rounded-lg text-white text-[13px] font-semibold">
                        <?php echo $page ?>
                    </span>
                    <?php if ($page < $totalPages): ?>
                    <a href="clientes.php?pagina=<?php echo $page + 1 ?>"
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
                <a id="modal-confirm-link" href="#" class="bg-red-500 text-white text-[13px] font-medium px-4 py-2 rounded-lg no-underline">Excluir cliente</a>
            </div>
        </div>
    </div>
</body>
</html>