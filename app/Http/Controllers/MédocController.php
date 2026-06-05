<?php

namespace App\Http\Controllers;

use App\Services\MedicamentService;
use App\Services\RapportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MédocController extends Controller
{
    protected MedicamentService $medicamentService;
    protected RapportService    $rapportService;

    public function __construct(MedicamentService $medicamentService, RapportService $rapportService)
    {
        $this->medicamentService = $medicamentService;
        $this->rapportService    = $rapportService;
    }



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
                'error'   => $exception->getMessage()
            ], 500);
        }
    }


    public function listeMedoc()
    {
        try {
            $medicaments = $this->medicamentService->getAllMedicaments();
            return view('ListeMédoc', compact('medicaments'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }


    public function rapportParMedoc(Request $request)
    {
        try {
            $idMedicament = $request->input('id_medicament');

            $medicaments = $this->medicamentService->getAllMedicaments();
            $rapports    = collect();
            $medocChoisi = null;

            if ($idMedicament) {
                $rapports    = $this->rapportService->getRapportsByMedicament((int) $idMedicament);
                $medocChoisi = $medicaments->firstWhere('id_medicament', (int) $idMedicament);
            }

            return view('RapportListe', compact('medicaments', 'rapports', 'medocChoisi', 'idMedicament'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
