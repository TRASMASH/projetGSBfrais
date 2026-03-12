<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RapportController extends Controller
{
    // LISTE DES RAPPORTS
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
            $id_visiteur = session('id_visiteur'); // VARCHAR dans ta base

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
                // AJOUT
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


}
