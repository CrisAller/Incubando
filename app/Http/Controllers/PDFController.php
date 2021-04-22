<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Egg;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\EggProjection;

class PDFController extends Controller
{
    public function create(Egg $egg, Request $request)
    {
        $imageChart = $request['pdfProjection'];
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('eggs.pdf')->with([
            'egg' => Egg::where('id', $egg->id)->with('specie')->first(),
            'projections' => EggProjection::where('egg_id', $egg->id)->orderBy('incubation_day')->get(),
            'projection_controller' => new EggProjectionController(),
            'imgChart' => $imageChart,
            'today' => Carbon::now()->format('d-m-Y H:i'),
        ]));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}
