<?php

namespace App\Http\Controllers;

use App\Services\FraisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RapportController extends Controller
{

    public function listRapport()
    {
        try {
            $fiches = DB::table('rapport_visite')
                ->join('praticien', 'rapport_visite.id_praticien', '=', 'praticien.id_praticien')
                ->select(
                    'rapport_visite.id_rapport',
                    'rapport_visite.id_praticien',
                    'rapport_visite.date_rapport',
                    'rapport_visite.bilan',
                    'rapport_visite.motif',
                    'praticien.nom_praticien',
                    'praticien.prenom_praticien'
                )
                ->get();

            return view('listerRapport', compact('fiches'));

        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }


    public function addRapport()
    {
        try {
            $rapport = new \stdClass();
            $rapport->id_rapport = null;
            $rapport->id_praticien = null;
            $rapport->date_rapport = date("Y-m-d");
            $rapport->bilan = "";
            $rapport->motif = "";

            $praticiens = DB::table('praticien')->orderBy('nom_praticien')->get();

            return view('formRapport', compact('rapport', 'praticiens'));

        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }


    public function saveRapport(Request $request)
    {
        try {
            $id_visiteur = session('id_visiteur');

            $id_rapport = $request->input('id_rapport');

            if ($id_rapport) {

                DB::table('rapport_visite')
                    ->where('id_rapport', $id_rapport)
                    ->update([
                        'id_praticien' => $request->id_praticien,
                        'date_rapport' => $request->date_rapport,
                        'bilan'        => $request->bilan,
                        'motif'        => $request->motif,
                    ]);
            } else {
                // ajout
                DB::table('rapport_visite')->insert([
                    'id_visiteur'  => $id_visiteur,
                    'id_praticien' => $request->id_praticien,
                    'date_rapport' => $request->date_rapport,
                    'bilan'        => $request->bilan,
                    'motif'        => $request->motif,
                ]);
            }

            return redirect('/listerRapport');

        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }


    public function editRapport($id)
    {
        try {

            $rapport = DB::table('rapport_visite')
                ->where('id_rapport', $id)
                ->first();


            $offerts = DB::table('offrir')
                ->join('medicament', 'offrir.id_medicament', '=', 'medicament.id_medicament')
                ->select(
                    'offrir.id_medicament',
                    'medicament.nom_commercial',
                    'offrir.qte_offerte'
                )
                ->where('offrir.id_rapport', $id)
                ->get();

            return view('listeMedicamentOffert', compact('rapport', 'offerts'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function modifierOffert($id_rapport, $id_medicament)
    {
        try {
            $offert = DB::table('offrir')
                ->where('id_rapport', $id_rapport)
                ->where('id_medicament', $id_medicament)
                ->first();

            $medicament = DB::table('medicament')
                ->where('id_medicament', $id_medicament)
                ->first();

            return view('formModifierOffert', compact('offert', 'medicament'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function saveModifierOffert(Request $request)
    {
        DB::table('offrir')
            ->where('id_rapport', $request->id_rapport)
            ->where('id_medicament', $request->id_medicament)
            ->update([
                'qte_offerte' => $request->qte_offerte
            ]);

        return redirect('/editRapport/'.$request->id_rapport);
    }
    public function listerRapport(Request $request)
    {
        try {
            $query = DB::table('rapport_visite')
                ->join('praticien', 'rapport_visite.id_praticien', '=', 'praticien.id_praticien')
                ->select(
                    'rapport_visite.*',
                    'praticien.nom_praticien',
                    'praticien.prenom_praticien'
                );

            // Recherche par nom praticien test
            if ($request->filled('nom')) {
                $query->where('praticien.nom_praticien', 'like', '%' . $request->nom . '%');
            }

            // Recherche par date2.0 test
            if ($request->filled('date')) {
                $query->where('rapport_visite.date_rapport', '=', $request->date);
            }

            $fiches = $query->get();

            return view('listerRapport', compact('fiches'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function ajouterOffert($id_rapport)
    {
        try {
            $medicaments = DB::table('medicament')->get();

            return view('formAjouterOffert', compact('id_rapport', 'medicaments'));

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function saveOffert(Request $request)
    {
        try {
            DB::table('offrir')->insert([
                'id_rapport'   => $request->id_rapport,
                'id_medicament'=> $request->id_medicament,
                'qte_offerte'  => $request->qte_offerte
            ]);

            return redirect('/editRapport/'.$request->id_rapport);

        } catch (\Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function listRapportAPI(Request $request)
    {
        try {
            $query = DB::table('rapport_visite')
                ->join('praticien', 'rapport_visite.id_praticien', '=', 'praticien.id_praticien')
                ->select(
                    'rapport_visite.*',
                    'praticien.nom_praticien',
                    'praticien.prenom_praticien'
                );

            $fiches = $query->get();

            return response()->json($fiches, 200);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des rapports',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function storeRapportAPI(Request $request)
    {
        try {
            $visiteur = auth('sanctum')->user();

            if (!$visiteur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            $id_visiteur = $visiteur->id_visiteur;

            DB::table('rapport_visite')->insert([
                'id_visiteur'  => $id_visiteur,
                'id_praticien' => $request->input('id_praticien'),
                'date_rapport' => $request->input('date_rapport'),
                'motif'        => $request->input('motif'),
                'bilan'        => $request->input('bilan')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rapport ajouté avec succès'
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du rapport',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function addRapportAPI()
    {
        try {
            $praticiens = DB::table('praticien')->orderBy('nom_praticien')->get();

            return response()->json([
                'praticiens' => $praticiens
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des praticiens',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

}
