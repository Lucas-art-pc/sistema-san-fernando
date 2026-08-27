document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalConfirm');
  const modalMsg = document.getElementById('modalMsg');
  const btnCancel = document.getElementById('modalCancel');
  const btnOk = document.getElementById('modalOk');
  const tabela = document.getElementById('tabela');
  const form = document.getElementById('formSaida');

  let idParaExcluir = null;

  function abrirModalExcluir(id) {
    idParaExcluir = id;
    modalMsg.textContent = 'Tem certeza que deseja excluir esta saída?';
    modal.classList.add('active');
  }

  function fecharModal() {
    idParaExcluir = null;
    modal.classList.remove('active');
  }

  // Delegação de evento pois as linhas são geradas dinamicamente (paginação/filtro)
  tabela.addEventListener('click', (e) => {
    const btnExcluir = e.target.closest('.btn-excluir');
    const btnEditar = e.target.closest('.btn-editar');

    if (btnExcluir) {
      abrirModalExcluir(btnExcluir.dataset.id);
    }

    if (btnEditar) {
      const linha = btnEditar.closest('tr');
      form.querySelector('[name="id"]').value = btnEditar.dataset.id;
      form.querySelector('[name="descricao_receita"]').value = linha.children[1].textContent.trim();
      form.querySelector('[name="categoria_receita"]').value = linha.children[2].textContent.trim().toLowerCase();
      form.querySelector('[name="valor_receita"]').value = linha.children[3].textContent
        .replace('R$', '')
        .trim()
        .replace('.', '')
        .replace(',', '.');
      form.scrollIntoView({ behavior: 'smooth' });
    }
  });

  btnCancel.addEventListener('click', fecharModal);

  btnOk.addEventListener('click', () => {
    if (idParaExcluir) {
      fetch('/exclui-receita', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `idReceita=${encodeURIComponent(idParaExcluir)}`
      })
        .then(response => response.json())
        .then(data => {
          if (data.sucesso) {
            location.reload();
          } else {
            alert(data.erro || 'Não foi possível excluir o registro.');
          }
        })
        .catch(() => {
          alert('Erro de comunicação com o servidor.');
        });
    }
    fecharModal();
  });
  
  modal.addEventListener('click', (e) => {
    if (e.target === modal) fecharModal();
  });
});