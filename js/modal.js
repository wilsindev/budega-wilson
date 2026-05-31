function abrirModal(tipo, nome, url) {
    document.getElementById('modal-title').textContent = 'Excluir ' + tipo;
    document.getElementById('modal-desc').textContent = 'Tem certeza que deseja excluir "' + nome + '"? Esta ação não pode ser desfeita.';
    document.getElementById('modal-confirm-link').href = url;
    document.getElementById('modal-overlay').style.display = 'flex';
}
function fecharModal() {
    document.getElementById('modal-overlay').style.display = 'none';
}
document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if(e.target === this) fecharModal();
});