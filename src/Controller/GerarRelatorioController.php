<?php

namespace App\Controller;

use App\Repositories\ReceitasRepository;
use Dompdf\Dompdf;
use Dompdf\Options;

class GerarRelatorioController implements Controller
{

    public function __construct(
        private ReceitasRepository $receitasRepository
    ) {}

    public function requestProcess(): void
    {
        $dataInicio = $_GET['data_inicio'] ?? null;
        $dataFim    = $_GET['data_fim'] ?? null;
        $tipoFront  = $_GET['tipo'] ?? 'ambos'; // ambos | in | out

        if (!$dataInicio || !$dataFim) {
            http_response_code(400);
            echo 'Data início e data fim são obrigatórias.';
            return;
        }

        $tipoReceita = match ($tipoFront) {
            'in'  => 'entrada',
            'out' => 'despesa',
            default => null, // 'ambos' ou qualquer valor inesperado
        };

        $receitas = $this->receitasRepository->exibirRelatorio(
            $dataInicio,
            $dataFim,
            $tipoReceita
        );

        $totalEntradas = 0;
        $totalSaidas   = 0;
        foreach ($receitas as $r) {
            if ($r->getTipoReceita() === 'entrada') {
                $totalEntradas += $r->getValorReceita();
            } else {
                $totalSaidas += $r->getValorReceita();
            }
        }

        $html = $this->renderHtml($receitas, $dataInicio, $dataFim, $totalEntradas, $totalSaidas);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            "relatorio_{$dataInicio}_a_{$dataFim}.pdf",
            ['Attachment' => true] // false = abre no navegador em vez de baixar
        );
    }

    private function renderHtml(array $receitas, string $inicio, string $fim, float $totalEntradas, float $totalSaidas): string
    {
        ob_start();
        include __DIR__ . '/../Views/relatorio_pdf.php';
        return ob_get_clean();
    }
}