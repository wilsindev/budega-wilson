<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ . '/../includes/vendaquery.class.php';
    require_once __DIR__ . '/../includes/produtoquery.class.php';
    require_once __DIR__ . '/../includes/clientequery.class.php';
    require_once __DIR__ . '/../config/conexao.php';

    $vendaQuery = new VendaQuery($pdo);
    $produtoQuery = new ProdutoQuery($pdo);
    $clienteQuery = new ClienteQuery($pdo);
    $totalClientes = $clienteQuery->contarClientes();
    $totalProdutos = $produtoQuery->contarProdutos();
    $clientes = $clienteQuery->listarClientes($totalClientes, 0);
    $produtos = $produtoQuery->listarProdutos($totalProdutos, 0);
    $erro = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $clienteId = !empty($_POST['cliente_id']) ? intval($_POST['cliente_id']) : null;
        $itens = $_POST['itens'] ?? [];
        $total = 0;
        $vendaStatus = $_POST['status_pagamento'];

        if (empty($itens)) {
            $erro = "Adicione ao menos um produto para finalizar a venda.";
        } else {
            foreach ($itens as $item) {
                $preco = floatval($item['preco'] ?? 0);
                $qtd = intval($item['quantidade'] ?? 0);
                $pid = intval($item['produto_id'] ?? 0);

                if ($pid <= 0 || $qtd <= 0 || $preco <= 0) {
                    $erro = "Dados de produto inválidos. Verifique os itens adicionados.";
                    break;
                }
                $total += $preco * $qtd;
            }
        }

        if (!$erro) {

            $vendaId = $vendaQuery->adicionarVenda($clienteId, $total, $vendaStatus);

            foreach ($itens as $item) {
                $vendaQuery->adicionarItemVenda(
                    $vendaId,
                    intval($item['produto_id']),
                    intval($item['quantidade']),
                    floatval($item['preco'])
                );
            }

            header("Location: vendas.php?status=criada");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="../js/select.js"></script>
    <script defer src="../js/nova_venda.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../assets/logobudegafav.png">
    <title>Loja do Wilson - Nova Venda</title>
</head>
<body class="w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="w-full min-h-screen py-10 px-4">
        <form action="" method="post" id="form-venda">
        <div class="max-w-[1100px] mx-auto flex flex-col gap-6">

            <!-- Título -->
            <div class="flex items-center gap-3">
                <a href="vendas.php" class="text-slate-400 hover:text-indigo-500 transition-colors text-[13px] flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i> Voltar
                </a>
                <h2 class="text-[17px] font-semibold text-slate-800">Nova venda</h2>
            </div>

            <div class="flex gap-6 items-start flex-wrap lg:flex-nowrap">
                <?php if($erro): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline"><?= $erro ?></span>
                </div>
                <?php endif; ?>
                <!-- ESQUERDA: Produtos -->
                <div class="card rounded-2xl p-6 flex flex-col gap-4 w-full lg:w-[55%]">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-[14px] font-semibold text-slate-800">Produtos</h3>
                        <p class="text-[12px] text-slate-400">Clique para adicionar à venda.</p>
                    </div>
                    <div class="divider"></div>

                    <!-- Busca -->
                    <div class="relative">
                        <input type="text" id="busca-produto" placeholder="Buscar produto…"
                               class="field pl-8" oninput="filtrarProdutos(this.value)">
                    </div>

                    <!-- Lista de produtos -->
                    <div class="flex flex-col gap-2 max-h-[420px] overflow-y-auto pr-1" id="lista-produtos">
                        <?php foreach ($produtos as $produto): ?>
                        <div class="produto-card" onclick="abrirQtd(<?= $produto->id ?>, '<?= htmlspecialchars($produto->nome) ?>', <?= $produto->preco ?>)"
                             data-nome="<?= strtolower(htmlspecialchars($produto->nome)) ?>">
                            <div>
                                <p class="text-[13px] font-medium text-slate-700"><?= htmlspecialchars($produto->nome) ?></p>
                                <p class="text-[11px] text-slate-400"><?= $produto->categoria ?? '' ?></p>
                            </div>
                            <span class="text-[13px] font-medium text-emerald-600 whitespace-nowrap">
                                R$ <?= number_format($produto->preco, 2, ',', '.') ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- DIREITA -->
                <div class="flex flex-col gap-4 w-full lg:w-[45%]">

                    <!-- Cliente -->
                    <div class="card rounded-2xl p-6 flex flex-col gap-4">
                        <h3 class="text-[14px] font-semibold text-slate-800">Cliente <span class="text-slate-400 font-normal text-[12px]">(opcional)</span></h3>
                        <div class="divider"></div>
                        <div class="flex flex-col gap-1.5">
                            <label>Buscar por nome</label>
                            <select name="cliente_id" id="cliente_id" class="select">
                                <option value="">Selecione um cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= $cliente->id ?>"><?= htmlspecialchars($cliente->nome) ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>

                    <!-- Resumo -->
                    <div class="card rounded-2xl p-6 flex flex-col gap-4">
                        <h3 class="text-[14px] font-semibold text-slate-800">Resumo</h3>
                        <div class="divider"></div>

                        <div id="itens-resumo" class="flex flex-col gap-0 min-h-[80px]">
                            <p class="text-[12px] text-slate-400 text-center py-4" id="resumo-vazio">Nenhum produto adicionado.</p>
                        </div>

                        <div class="divider"></div>
                        <div class="flex flex-col gap-1">
                            <div class="flex justify-between text-[13px] text-slate-500">
                                <span>Subtotal</span>
                                <span id="subtotal-val">R$ 0,00</span>
                            </div>
                            <div class="flex justify-between text-[15px] font-semibold text-slate-800 mt-1">
                                <span>Total</span>
                                <span id="total-val">R$ 0,00</span>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="flex gap-2">
                            <input type="radio" name="status_pagamento" value="pendente" id="status-pendente" class="peer/pendente hidden" checked>
                            <label for="status-pendente"
                                class="flex items-center gap-1.5 text-[13px] font-medium text-slate-500 border border-slate-200 rounded-lg px-3.5 py-2 cursor-pointer transition-colors peer-checked/pendente:bg-slate-100 peer-checked/pendente:text-slate-700 peer-checked/pendente:border-slate-300">
                                <i class="fa-solid fa-clock text-[11px]"></i>
                                Fiado
                            </label>

                            <input type="radio" name="status_pagamento" value="pago" id="status-pago" class="peer/pago hidden">
                            <label for="status-pago"
                                class="flex items-center gap-1.5 text-[13px] font-medium text-slate-500 border border-slate-200 rounded-lg px-3.5 py-2 cursor-pointer transition-colors peer-checked/pago:bg-emerald-50 peer-checked/pago:text-emerald-700 peer-checked/pago:border-emerald-300">
                                <i class="fa-solid fa-check text-[11px]"></i>
                                Pago
                            </label>
                        </div>
                        <input type="hidden" name="subtotal" id="input-subtotal">
                        <input type="hidden" name="total_final" id="input-total">

                        <button type="submit" id="btn-finalizar" disabled
                                class="btn-primary text-white font-medium text-[13px] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2 disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none">
                            <i class="fa-solid fa-check text-[11px]"></i>
                            Finalizar venda
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </main>

    <!-- Modal quantidade -->
    <div id="modal-qtd" class="hidden fixed inset-0 bg-slate-900/35 z-50 flex items-center justify-center">
        <div class="bg-white border border-slate-200 rounded-2xl p-7 w-full max-w-sm shadow-xl">
            <p class="text-[15px] font-semibold text-slate-800 mb-1" id="modal-produto-nome"></p>
            <p class="text-[13px] text-slate-400 mb-4" id="modal-produto-preco"></p>
            <div class="flex flex-col gap-1.5 mb-4">
                <label class="text-[13px] font-medium text-slate-600">Quantidade</label>
                <input type="number" id="input-qtd" min="1" value="1" class="field">
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="fecharModal()" class="bg-white border border-slate-200 text-slate-500 text-[13px] font-medium px-4 py-2 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarItem()" class="bg-indigo-600 text-white text-[13px] font-medium px-4 py-2 rounded-lg cursor-pointer hover:bg-indigo-700 transition-colors">
                    Adicionar
                </button>
            </div>
        </div>
    </div>
</body>
</html>