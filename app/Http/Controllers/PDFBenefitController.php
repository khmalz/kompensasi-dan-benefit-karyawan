<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFBenefitController extends Controller
{
    public function index(Benefit $benefit)
    {
        $pdf = Pdf::loadView('pdf.benefit', compact('benefit'));
        return $pdf->stream('tunjangan_' . $benefit->code . '.pdf');
    }

    public function done(Request $request)
    {
        $benefits = Benefit::where('status', Benefit::SELESAI)
            ->when(!$request->has("all"), function ($query) use ($request) {
                $query->whereBetweenDate([$request->started_at, $request->ended_at]);
            })
            ->latest()->get();

        if ($benefits->isEmpty()) {
            return back()->with('fail', 'Tunjangan Yang Ingin di Eksport Tidak Ada');
        }

        $totalBenefit = $benefits->sum('amount');

        $pdf = Pdf::loadView('pdf.benefit-done', compact('benefits', 'totalBenefit'));
        return $pdf->stream('tunjangan_sudah.pdf');
    }
}
