<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ . '/../includes/vendaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $page = $_GET['pagina'] ?? 1;
    $limitPerPage = 10;
    $offset = ($page - 1) * $limitPerPage;
    $query = new VendaQuery($pdo);
    $vendas = $query->listarVendas($limitPerPage, $offset);
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
    <title>Loja do Wilson - Vendas</title>
    <style>
        * { font-family: 'Geist', system-ui, sans-serif; }
        code, .mono { font-family: 'Geist Mono', monospace; }
        main { position: relative; z-index: 1; }
        .card-glow {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06), 0 8px 24px rgba(15,23,42,0.05);
        }
        .brand-text { color: #1e293b; }
        tr.data-row { transition: background 0.12s ease; }
        tr.data-row:hover { background: #f0f4ff; }
        tr.data-row:hover td:first-child { border-left: 2px solid #818cf8; padding-left: 14px; }
        tr.data-row td:first-child { border-left: 2px solid transparent; transition: border-color 0.12s, padding 0.12s; }
        .divider { height: 1px; background: #e8ecf0; }
        .btn-add {
            background: #4f46e5;
            box-shadow: 0 1px 3px rgba(79,70,229,0.25), 0 1px 0 rgba(255,255,255,0.1) inset;
            transition: filter 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-add:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
        .btn-add:active { transform: translateY(0); }
        .action-del {
            background: #fff5f5; border: 1px solid #fecaca; color: #ef4444; transition: all 0.12s;
        }
        .action-del:hover { background: #fee2e2; border-color: #f87171; color: #dc2626; }
        .action-view {
            background: #eff6ff; border: 1px solid #bfdbfe; color: #3b82f6; transition: all 0.12s;
        }
        .action-view:hover { background: #dbeafe; border-color: #93c5fd; color: #2563eb; }
        .page-current { background: #4f46e5; color: #fff; box-shadow: 0 2px 6px rgba(79,70,229,0.3); }
        .page-btn { background: #ffffff; border: 1px solid #dde2e8; color: #64748b; transition: all 0.12s; }
        .page-btn:hover { background: #eef0fe; border-color: #818cf8; color: #4f46e5; }
        .badge-id { background: #f1f5f9; border: 1px solid #e2e8f0; }
        .badge-cliente { background: #eef2ff; border: 1px solid #c7d2fe; }
        .badge-anonimo { background: #f8fafc; border: 1px solid #e2e8f0; color: #94a3b8; }
        thead th {
            background: #f8fafc; font-size: 10px; letter-spacing: 0.08em;
            color: #94a3b8; font-weight: 600; text-transform: uppercase; border-bottom: 1px solid #e8ecf0;
        }
        .card-glow { animation: fadein 0.3s ease; }
        @keyframes fadein { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .table-wrap { border: 1px solid #e8ecf0; }
        tr.data-row { border-top: 1px solid #f1f5f9; }
        .page-info { color: #94a3b8; }
        .price-val { color: #059669; }
    </style>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="card-glow rounded-2xl p-8 w-full max-w-[800px] flex flex-col gap-7">

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
                            <th class="px-4 py-3 text-left text-[#060606]">ID</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Cliente</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Total</th>
                            <th class="px-4 py-3 text-left text-[#060606]">Data</th>
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
                                <span class="badge-id mono rounded-md px-2 py-0.5 text-[11px]">
                                    #<?= $venda->id ?>
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <?php if($venda->cliente): ?>
                                    <span class="badge-cliente rounded-full px-2.5 py-0.5 text-[11px] font-medium text-indigo-700">
                                        <?= htmlspecialchars($venda->cliente) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge-anonimo rounded-full px-2.5 py-0.5 text-[11px] font-medium">
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
                            <td class="px-4 py-3.5">
                                <div class="flex gap-1.5 justify-center">
                                    <?php if($_SESSION['is_admin'] === 1): ?>
                                    <button onclick="abrirModal('venda', '#<?= $venda->id ?>', 'cancelar.php?id=<?= $venda->id ?>')"
                                       class="action-del text-[11px] rounded-md px-2.5 py-1.5 font-medium">
                                        <i class="fa-solid fa-trash-can mr-1 text-[9px]"></i>Cancelar
                                    </button>
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
                    <a href="vendas.php?pagina=<?= $page + 1 ?>"
                       class="page-btn flex justify-center items-center w-8 h-8 rounded-lg text-sm transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal cancelar -->
    <div id="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.35); z-index:50; align-items:center; justify-content:center;">
        <div style="background:#fff; border:1px solid #e8ecf0; border-radius:16px; padding:28px; width:100%; max-width:380px; font-family:'Geist',system-ui,sans-serif;">
            <div style="width:40px;height:40px;background:#fff5f5;border:1px solid #fecaca;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#ef4444;margin-bottom:14px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <p id="modal-title" style="font-size:15px;font-weight:600;color:#1e293b;margin:0 0 6px;"></p>
            <p id="modal-desc" style="font-size:13px;color:#64748b;margin:0 0 20px;line-height:1.5;"></p>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button onclick="fecharModal()" style="background:#fff;border:1px solid #dde2e8;color:#64748b;font-size:13px;font-weight:500;padding:8px 16px;border-radius:8px;cursor:pointer;">Voltar</button>
                <a id="modal-confirm-link" href="#" style="background:#ef4444;color:#fff;font-size:13px;font-weight:500;padding:8px 16px;border-radius:8px;text-decoration:none;">Cancelar venda</a>
            </div>
        </div>
    </div>
</body>
</html>