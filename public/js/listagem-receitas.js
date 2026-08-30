document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalConfirm');
  const modalMsg = document.getElementById('modalMsg');
  const btnCancel = document.getElementById('modalCancel');
  const btnOk = document.getElementById('modalOk');
  const tabela = document.getElementById('tabela');

  // --- Modal de edição ---
  const modalEditar = document.getElementById('modalEditar');
  const formEditar = document.getElementById('formEditarReceita');
  const editCancel = document.getElementById('editCancel');

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

  function abrirModalEditar(linha, id) {
    document.getElementById('editId').value = id;
    document.getElementById('editDescricao').value = linha.children[1].textContent.trim();

    const categoriaTexto = linha.children[2].textContent
      .trim()
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, ''); // remove acentos (ex: "salários" -> "salarios")
    document.getElementById('editCategoria').value = categoriaTexto;

    document.getElementById('editValor').value = linha.children[3].textContent
      .replace('R$', '')
      .trim()
      .replace('.', '')
      .replace(',', '.');

    document.getElementById('editTipo').value = linha.children[4].textContent.trim().toLowerCase();

    // Data: converte de dd/mm/yyyy (exibido na tabela) para yyyy-mm-dd (input type=date)
    const dataTexto = linha.children[0].textContent.trim();
    const [dia, mes, ano] = dataTexto.split('/');
    document.getElementById('editData').value = `${ano}-${mes}-${dia}`;

    modalEditar.classList.add('active');
  }

  function fecharModalEditar() {
    formEditar.reset();
    modalEditar.classList.remove('active');
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
      abrirModalEditar(linha, btnEditar.dataset.id);
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

  // --- Eventos do modal de edição ---
  editCancel.addEventListener('click', fecharModalEditar);

  modalEditar.addEventListener('click', (e) => {
    if (e.target === modalEditar) fecharModalEditar();
  });

  formEditar.addEventListener('submit', (e) => {
    e.preventDefault();

    const dados = new URLSearchParams(new FormData(formEditar, e.submitter));

    fetch('/edita-receita', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: dados.toString()
    })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          location.reload();
        } else {
          alert(data.erro || 'Não foi possível salvar as alterações.');
        }
      })
      .catch(() => {
        alert('Erro de comunicação com o servidor.');
      });
  });
});