<?php

namespace App\Http\Controllers;

use App\Services\FraisService;
use Illuminate\Support\Facades\DB;
use Exception;

class MédocController extends Controller
{

    public function topMedicaments()
    {
        try {
            $medicaments = DB::table('offrir')
                ->join('medicament', 'offrir.id_medicament', '=', 'medicament.id_medicament')
                ->select(
                    'medicament.nom_commercial',
                    DB::raw('SUM(offrir.qte_offerte) as total_offert')
                )
                ->groupBy('medicament.id_medicament', 'medicament.nom_commercial')
                ->orderByDesc('total_offert')
                ->limit(10)
                ->get();

            return view('topMedicaments', compact('medicaments'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function topMedicamentsAPI()
    {
        try {
            $medicaments = DB::table('medicament')
                ->join('offrir', 'medicament.id_medicament', '=', 'offrir.id_medicament')
                ->select(
                    'medicament.id_medicament',
                    'medicament.nom_commercial',
                    DB::raw('SUM(offrir.qte_offerte) as total_offert')
                )
                ->groupBy('medicament.id_medicament', 'medicament.nom_commercial')
                ->orderByDesc('total_offert')
                ->get();

            return response()->json($medicaments, 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des médicaments',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}

