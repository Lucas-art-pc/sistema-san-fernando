let chart;

export function formatarMoeda(valor) {
  return 'R$ ' + Number(valor).toLocaleString('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
}

export function renderizarGrafico(labels, entradas, saidas) {
  const ctx = document.getElementById('mainChart').getContext('2d');

  if (chart) chart.destroy();

  chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Entradas',
          data: entradas,
          backgroundColor: 'rgba(34, 197, 94, 0.7)',
        },
        {
          label: 'Saídas',
          data: saidas,
          backgroundColor: 'rgba(239, 68, 68, 0.7)',
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { callback: (valor) => formatarMoeda(valor) },
        },
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: (contexto) => `${contexto.dataset.label}: ${formatarMoeda(contexto.raw)}`,
          },
        },
      },
    },
  });
}