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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $clienteId = !empty($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
        $itens = $_POST['itens'] ?? [];
        $total = 0;

        foreach ($itens as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        if ($clienteId) {
            $total = $total * 0.90; // 10% desconto
        }

        $vendaId = $vendaQuery->adicionarVenda($clienteId, $total);

        foreach ($itens as $item) {
            $vendaQuery->adicionarItemVenda($vendaId, $item['produto_id'], $item['quantidade'], $item['preco']);
        }

        header("Location: vendas.php");
        exit;
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
                        <p class="text-[11px] text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-tag text-emerald-500"></i>
                            Cliente cadastrado recebe <strong class="text-emerald-600">10% de desconto</strong>.
                        </p>
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
                            <div class="flex justify-between text-[13px] text-emerald-600" id="linha-desconto" style="display:none!important">
                                <span>Desconto (10%)</span>
                                <span id="desconto-val">- R$ 0,00</span>
                            </div>
                            <div class="flex justify-between text-[15px] font-semibold text-slate-800 mt-1">
                                <span>Total</span>
                                <span id="total-val">R$ 0,00</span>
                            </div>
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
    <div id="modal-qtd" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.35); z-index:50; align-items:center; justify-content:center;">
        <div style="background:#fff; border:1px solid #e8ecf0; border-radius:16px; padding:28px; width:100%; max-width:340px;">
            <p class="text-[15px] font-semibold text-slate-800 mb-1" id="modal-produto-nome"></p>
            <p class="text-[13px] text-slate-400 mb-4" id="modal-produto-preco"></p>
            <div class="flex flex-col gap-1.5 mb-4">
                <label>Quantidade</label>
                <input type="number" id="input-qtd" min="1" value="1" class="field">
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="fecharModal()" style="background:#fff;border:1px solid #dde2e8;color:#64748b;font-size:13px;font-weight:500;padding:8px 16px;border-radius:8px;cursor:pointer;">Cancelar</button>
                <button type="button" onclick="confirmarItem()" style="background:#4f46e5;color:#fff;font-size:13px;font-weight:500;padding:8px 16px;border-radius:8px;cursor:pointer;">Adicionar</button>
            </div>
        </div>
    </div>

    <script>
        let itens = [];
        let clienteSelecionado = null;
        let produtoAtual = null;

        function filtrarProdutos(q) {
            document.querySelectorAll('#lista-produtos .produto-card').forEach(card => {
                card.style.display = card.dataset.nome.includes(q.toLowerCase()) ? '' : 'none';
            });
        }

        function abrirQtd(id, nome, preco) {
            produtoAtual = { id, nome, preco };
            document.getElementById('modal-produto-nome').textContent = nome;
            document.getElementById('modal-produto-preco').textContent = 'R$ ' + preco.toFixed(2).replace('.', ',');
            document.getElementById('input-qtd').value = 1;
            document.getElementById('modal-qtd').style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modal-qtd').style.display = 'none';
        }

        function confirmarItem() {
            const qtd = parseInt(document.getElementById('input-qtd').value) || 1;
            const existente = itens.find(i => i.id === produtoAtual.id);
            if (existente) {
                existente.quantidade += qtd;
            } else {
                itens.push({ ...produtoAtual, quantidade: qtd });
            }
            fecharModal();
            renderResumo();
        }

        function removerItem(id) {
            itens = itens.filter(i => i.id !== id);
            renderResumo();
        }

        function renderResumo() {
            const container = document.getElementById('itens-resumo');
            container.innerHTML = ''; // limpa tudo incluindo inputs hidden

            if (itens.length === 0) {
                container.innerHTML = '<p class="text-[12px] text-slate-400 text-center py-4">Nenhum produto adicionado.</p>';
                document.getElementById('btn-finalizar').disabled = true;
                atualizarTotal();
                return;
        }
            document.getElementById('btn-finalizar').disabled = false;
            itens.forEach((item, idx) => {
                const row = document.createElement('div');
                row.className = 'item-row';
                row.innerHTML = `
                    <div style="flex:1">
                        <p style="font-size:13px;color:#334155;font-weight:500">${item.nome}</p>
                        <p style="font-size:11px;color:#94a3b8">${item.quantidade}x R$ ${item.preco.toFixed(2).replace('.',',')}</p>
                    </div>
                    <span style="font-size:13px;color:#059669;font-weight:500;white-space:nowrap">R$ ${(item.preco * item.quantidade).toFixed(2).replace('.',',')}</span>
                    <button type="button" onclick="removerItem(${item.id})" style="color:#ef4444;font-size:12px;background:none;border:none;cursor:pointer;padding:0 4px;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                container.appendChild(row);
            });

            // inputs hidden para o form
            container.querySelectorAll('.item-hidden').forEach(e => e.remove());
            itens.forEach((item, idx) => {
                ['produto_id','quantidade','preco'].forEach(campo => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = `itens[${idx}][${campo}]`;
                    inp.value = campo === 'produto_id' ? item.id : campo === 'quantidade' ? item.quantidade : item.preco;
                    inp.className = 'item-hidden';
                    container.appendChild(inp);
                });
            });

            atualizarTotal();
        }

        function atualizarTotal() {
            const subtotal = itens.reduce((s, i) => s + i.preco * i.quantidade, 0);
            const temDesconto = clienteSelecionado !== null;
            const desconto = temDesconto ? subtotal * 0.10 : 0;
            const total = subtotal - desconto;

            document.getElementById('subtotal-val').textContent = 'R$ ' + subtotal.toFixed(2).replace('.',',');
            document.getElementById('desconto-val').textContent = '- R$ ' + desconto.toFixed(2).replace('.',',');
            document.getElementById('total-val').textContent = 'R$ ' + total.toFixed(2).replace('.',',');
            document.getElementById('linha-desconto').style.display = temDesconto ? 'flex' : 'none';
            document.getElementById('input-subtotal').value = subtotal.toFixed(2);
            document.getElementById('input-total').value = total.toFixed(2);
        }



    document.addEventListener('DOMContentLoaded', function() {
        $('#cliente_id').on('change', function() {
            clienteSelecionado = this.value ? true : null;
            atualizarTotal();
        });

        document.getElementById('modal-qtd').addEventListener('click', function(e) {
            if (e.target === this) fecharModal();
        });
    });
    </script>
</body>
</html>