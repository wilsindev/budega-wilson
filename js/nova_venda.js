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
        document.getElementById('modal-qtd').classList.remove('hidden');
    }

    function fecharModal() {
        document.getElementById('modal-qtd').classList.add('hidden');
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
    container.innerHTML = '';

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
                <div class="flex-1">
                    <p class="text-[13px] text-slate-700 font-medium">${item.nome}</p>
                    <p class="text-[11px] text-slate-400">${item.quantidade}x R$ ${item.preco.toFixed(2).replace('.',',')}</p>
                </div>
                <span class="text-[13px] text-emerald-600 font-medium whitespace-nowrap">R$ ${(item.preco * item.quantidade).toFixed(2).replace('.',',')}</span>
                <button type="button" onclick="removerItem(${item.id})" class="text-red-400 text-[12px] bg-transparent border-none cursor-pointer px-1 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            container.appendChild(row);
        });

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
        document.getElementById('linha-desconto').classList.toggle('hidden', !temDesconto);
        document.getElementById('linha-desconto').classList.toggle('flex', temDesconto);
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