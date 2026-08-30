document.getElementById('btnPdf').addEventListener('click', () => {
  const inicio = document.getElementById('filtroDataInicio').value;
  const fim = document.getElementById('filtroDataFim').value;
  const tipo = document.getElementById('filtroTipo').value;

  console.log(inicio)

  if (!inicio || !fim) {
    alert('Selecione data início e data fim.');
    return;
  }

  const params = new URLSearchParams({ data_inicio: inicio, data_fim: fim, tipo });
  window.location.href = `/relatorio/pdf?${params.toString()}`;
});