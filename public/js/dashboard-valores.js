import { renderizarGrafico, formatarMoeda } from "./renderziar-grafico.js";

document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.period-tab');
  const wraps = {
    dia: document.getElementById('dashWrapDia'),
    mes: document.getElementById('dashWrapMes'),
    ano: document.getElementById('dashWrapAno'),
  };

  const inputDia = document.getElementById('dashDia');
  const inputMes = document.getElementById('dashMes');
  const inputAno = document.getElementById('dashAno');

  const elIn = document.getElementById('periodIn');
  const elOut = document.getElementById('periodOut');
  const elProfit = document.getElementById('periodProfit');
  const elSubIn = document.getElementById('subIn');
  const elSubOut = document.getElementById('subOut');
  const elChartTitle = document.getElementById('chartTitle');
  const elChartSub = document.getElementById('chartSub');

  function alternarAba(periodo) {
    tabs.forEach((tab) => tab.classList.toggle('active', tab.dataset.period === periodo));
    Object.entries(wraps).forEach(([chave, el]) => el.classList.toggle('hidden', chave !== periodo));
  }

  function atualizarCards(dados, periodo, rotuloPeriodoTexto) {
    elIn.textContent = formatarMoeda(dados.entradas);
    elOut.textContent = formatarMoeda(dados.saidas);
    elProfit.textContent = formatarMoeda(dados.lucro);
    elSubIn.textContent = `${dados.qtd_entradas} lançamento${dados.qtd_entradas === 1 ? '' : 's'}`;
    elSubOut.textContent = `${dados.qtd_saidas} lançamento${dados.qtd_saidas === 1 ? '' : 's'}`;
    elChartTitle.textContent = 'Entradas vs Saídas';
    elChartSub.textContent = rotuloPeriodoTexto;
  }

  async function carregarDados(periodo, params, rotuloPeriodoTexto) {
    const query = new URLSearchParams({ periodo, ...params }).toString();
    const resposta = await fetch(`/dashboard/dados?${query}`);
    const dados = await resposta.json();

    atualizarCards(dados, periodo, rotuloPeriodoTexto);
    renderizarGrafico(dados.grafico.labels, dados.grafico.entradas, dados.grafico.saidas);
  }

  function carregarPeriodoAtual() {
    const periodo = document.querySelector('.period-tab.active')?.dataset.period || 'dia';

    if (periodo === 'dia') {
      const data = inputDia.value || new Date().toISOString().slice(0, 10);
      inputDia.value = data;
      carregarDados('dia', { data }, `Dia ${data.split('-').reverse().join('/')}`);
      return;
    }

    if (periodo === 'mes') {
      const valor = inputMes.value || new Date().toISOString().slice(0, 7); // formato YYYY-MM
      inputMes.value = valor;
      const [ano, mes] = valor.split('-').map(Number);
      carregarDados('mes', { ano, mes }, `${String(mes).padStart(2, '0')}/${ano}`);
      return;
    }

    const ano = inputAno.value || new Date().getFullYear();
    inputAno.value = ano;
    carregarDados('ano', { ano }, `Ano ${ano}`);
  }

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      alternarAba(tab.dataset.period);
      carregarPeriodoAtual();
    });
  });

  inputDia.addEventListener('change', carregarPeriodoAtual);
  inputMes.addEventListener('change', carregarPeriodoAtual);
  inputAno.addEventListener('change', carregarPeriodoAtual);

  // Carrega o dia atual assim que a página abre
  carregarPeriodoAtual();
});