function abrirModal(tipo, nome, url) {
    document.getElementById('modal-title').textContent = 'Excluir ' + tipo;
    document.getElementById('modal-desc').textContent = 'Tem certeza que deseja excluir "' + nome + '"? Esta ação não pode ser desfeita.';
    document.getElementById('modal-confirm-link').href = url;
    const overlay = document.getElementById('modal-overlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
}

function fecharModal() {
    const overlay = document.getElementById('modal-overlay');
    overlay.classList.remove('flex');
    overlay.classList.add('hidden');
}

document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) fecharModal();
});