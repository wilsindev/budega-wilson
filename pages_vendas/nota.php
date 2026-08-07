<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ . '/../includes/vendaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';

    $vendaId = $_GET['id'] ?? null;
    if (!$vendaId) {
        header("Location: vendas.php");
        exit;
    }

    $query = new VendaQuery($pdo);
    $venda = $query->getDadosVenda($vendaId);
    if (!$venda) {
        header("Location: vendas.php");
        exit;
    }

    $produtos = $query->getProdutosVenda($vendaId);

    $subtotal = 0;
    foreach ($produtos as $item) {
        $subtotal += $item->quantidade * $item->preco_unitario;
    }
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
    <link rel="stylesheet" href="../css/index.css">
    <title>Nota #<?= $venda->id ?> - Loja do Wilson</title>
</head>
<body class="bg-[#f4f6f9] text-slate-700 w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center w-full min-h-screen py-14 px-4">
        <div class="w-full max-w-[420px] flex flex-col gap-5">

            <a href="vendas.php" class="text-slate-400 hover:text-indigo-500 transition-colors text-[13px] flex items-center gap-1 w-fit">
                <i class="fa-solid fa-arrow-left text-[11px]"></i> Voltar
            </a>

            <!-- Cupom -->
            <div class="bg-white shadow-sm rounded-2xl px-8 py-8 flex flex-col">

                <!-- Cabeçalho -->
                <div class="flex flex-col items-center gap-1 mb-5">
                    <p class="font-mono text-[13px] font-medium text-slate-800 tracking-widest uppercase">Loja do Wilson</p>
                    <p class="font-mono text-[10px] text-slate-400">Russas - CE</p>
                </div>

                <div class="border-t border-dashed border-slate-200 mb-4"></div>

                <!-- Dados -->
                <div class="font-mono text-[11px] text-slate-500 flex flex-col gap-1.5 mb-4">
                    <div class="flex justify-between">
                        <span>Recibo Nº</span>
                        <span class="text-slate-700 font-medium"><?= str_pad($venda->id, 6, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>DATA</span>
                        <span class="text-slate-700"><?= date('d/m/Y', strtotime($venda->data)) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>HORA</span>
                        <span class="text-slate-700"><?= date('H:i', strtotime($venda->data)) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>CLIENTE</span>
                        <span class="text-slate-700"><?= $venda->cliente ? htmlspecialchars(mb_strtoupper($venda->cliente)) : 'CONSUMIDOR' ?></span>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 mb-4"></div>

                <!-- Header itens -->
                <div class="font-mono text-[10px] text-slate-400 flex justify-between uppercase mb-2">
                    <span class="w-[42%]">Produto</span>
                    <span class="w-[12%] text-center">Qtd</span>
                    <span class="w-[22%] text-right">Unit.</span>
                    <span class="w-[24%] text-right">Total</span>
                </div>

                <!-- Itens -->
                <div class="flex flex-col gap-2 mb-4">
                    <?php foreach ($produtos as $item): ?>
                    <div class="font-mono text-[11px] text-slate-700 flex justify-between items-start">
                        <span class="w-[42%] leading-tight break-words"><?= htmlspecialchars(mb_strtoupper($item->produto)) ?></span>
                        <span class="w-[12%] text-center text-slate-500"><?= $item->quantidade ?></span>
                        <span class="w-[22%] text-right text-slate-500"><?= number_format($item->preco_unitario, 2, ',', '.') ?></span>
                        <span class="w-[24%] text-right font-medium"><?= number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-dashed border-slate-200 mb-4"></div>

                <!-- Totais -->
                <div class="font-mono text-[11px] flex flex-col gap-1.5 mb-5">
                    <div class="flex justify-between text-slate-500">
                        <span>SUBTOTAL</span>
                        <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                    </div>
                    <?php if ($venda->cliente): ?>
                    <div class="flex justify-between text-emerald-600">
                        <span>Cliente: <?= htmlspecialchars(mb_strtoupper($venda->cliente)) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-slate-800 font-medium text-[15px] mt-1">
                        <span>TOTAL</span>
                        <span>R$ <?= number_format($venda->total, 2, ',', '.') ?></span>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 mb-5"></div>

                <!-- Rodapé -->
                <div class="flex flex-col items-center gap-2">
                    <p class="font-mono text-[10px] text-slate-400 tracking-widest"><?= str_pad($venda->id, 13, '0', STR_PAD_LEFT) ?></p>
                    <p class="font-mono text-[11px] text-slate-500 uppercase tracking-widest mt-3 text-center">Obrigado pela preferência!</p>
                </div>
            </div>

            <!-- Imprimir -->
            <button onclick="window.print()" class="btn-secondary flex items-center justify-center gap-2 text-[13px] font-medium px-4 py-2.5 rounded-xl w-full cursor-pointer">
                <i class="fa-solid fa-print text-[11px]"></i>
                Imprimir cupom
            </button>

        </div>
    </main>
</body>
</html>