<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ . '/../includes/vendaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $page = $_GET['pagina'] ?? 1;
    $limitPerPage = 10;
    $offset = ($page - 1) * $limitPerPage;
    $query = new VendaQuery($pdo);
    $vendas = $query->listarVendas($limitPerPage, $offset);
    $totalVendas = $query->contarVendas();
    $totalPages = ceil($totalVendas / $limitPerPage);
    $sucesso = $_GET['status'] ?? null;
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
    <title>Loja do Wilson - Vendas</title>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="card-glow rounded-2xl p-8 w-full max-w-[900px] flex flex-col gap-7">
            <?php if ($sucesso): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Prontinho!</strong>
                    <span class="block sm:inline">Venda <?= htmlspecialchars($sucesso) ?> com sucesso!</span>
                </div>
            <?php endif; ?>
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h2 class="text-[17px] font-semibold brand-text leading-tight">Vendas</h2>
                <a href="nova_venda.php"
                   class="btn-add flex items-center gap-2 text-white text-[13px] font-medium px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    Nova venda
                </a>
            </div>

            <div class="divider"></div>

            <!-- Tabela -->
            <div class="table-wrap rounded-xl overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-[#060606]">Cliente</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Total</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Data</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Status</th>
                            <th class="px-4 py-3 text-center w-28 text-[#060606]">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($vendas)): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[13px] text-slate-400">Nenhuma venda registrada.</td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach($vendas as $venda): ?>
                        <tr class="data-row border-t border-slate-100">
                            <td class="px-4 py-3.5">
                                <?php if($venda->cliente): ?>
                                    <span class="badge-cliente rounded-full px-2.5 py-0.5 text-[13px] font-medium text-indigo-700">
                                        <?= htmlspecialchars($venda->cliente) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge-anonimo rounded-full px-2.5 py-0.5 text-[13px] font-medium">
                                        Anônimo
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5 text-[13px] price-val font-medium mono">
                                R$ <?= number_format($venda->total, 2, ',', '.') ?>
                            </td>
                            <td class="px-4 py-3.5 text-[13px] text-slate-500 mono whitespace-nowrap">
                                <?= date('d/m/Y H:i', strtotime($venda->data)) ?>
                            </td>
                            <td class="px-4 py-3.5 text-[13px] text-slate-500 mono whitespace-nowrap">
                                <?php if($venda->status_pagamento === 'pago'): ?>
                                    <span class="rounded-full px-2.5 py-0.5 text-[13px] font-medium text-green-700">
                                        Paga
                                    </span>
                                <?php else: ?>
                                    <span class="rounded-full px-2.5 py-0.5 text-[13px] font-medium text-red-700">
                                        Não pago
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="grid grid-cols-3 gap-3 justify-items-center w-[120px] mx-auto">
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <button onclick="abrirModal('venda', '#<?= $venda->id ?>', 'excluir.php?id=<?= $venda->id ?>')"
                                    title="Cancelar"
                                    class="action-del w-8 h-8 rounded-md flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-[12px]"></i>
                                    </button>
                                    <?php else: ?>
                                    <div class="w-8 h-8"></div>
                                    <?php endif; ?>

                                    <a href="nota.php?id=<?= $venda->id ?>"
                                    title="Ver nota"
                                    class="action-edit w-8 h-8 rounded-md flex items-center justify-center">
                                        <i class="fa-solid fa-receipt text-[12px]"></i>
                                    </a>

                                    <?php if($venda->status_pagamento !== 'pago'): ?>
                                    <a href="editar.php?id=<?= $venda->id ?>"
                                    title="Confirmar pagamento"
                                    class="bg-green-600 text-white w-8 h-8 rounded-md flex items-center justify-center hover:bg-green-700 transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-[12px]"></i>
                                    </a>
                                    <?php else: ?>
                                    <div class="w-8 h-8"></div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="flex justify-between items-center">
                <span class="text-[11px] page-info">Página <?= $page ?></span>
                <div class="flex gap-1.5">
                    <?php if ($page - 1 > 0): ?>
                    <a href="vendas.php?pagina=<?= $page - 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                    <?php endif; ?>
                    <span class="page-current flex justify-center items-center w-8 h-8 rounded-lg text-white text-[13px] font-semibold">
                        <?= $page ?>
                    </span>
                    <?php if ($page < $totalPages): ?>
                    <a href="vendas.php?pagina=<?= $page + 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                    <?php endif;?>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal cancelar -->
    <div id="modal-overlay" class="hidden fixed inset-0 bg-slate-900/35 z-50 items-center justify-center">
        <div class="bg-white border border-slate-200 rounded-2xl p-7 w-full max-w-sm font-sans">
            <div class="w-10 h-10 bg-red-50 border border-red-200 rounded-xl flex items-center justify-center text-red-500 mb-3.5">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <p id="modal-title" class="text-[15px] font-semibold text-slate-800 mb-1.5"></p>
            <p id="modal-desc" class="text-[13px] text-slate-500 mb-5 leading-relaxed"></p>
            <div class="flex gap-2 justify-end">
                <button onclick="fecharModal()" class="bg-white border border-slate-200 text-slate-500 text-[13px] font-medium px-4 py-2 rounded-lg cursor-pointer">Voltar</button>
                <a id="modal-confirm-link" href="#" class="bg-red-500 text-white text-[13px] font-medium px-4 py-2 rounded-lg no-underline">Cancelar venda</a>
            </div>
        </div>
    </div>
</body>
</html>