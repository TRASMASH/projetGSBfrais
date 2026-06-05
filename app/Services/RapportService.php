<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RapportService
{

    public function getRapports($nom = null, $date = null)
    {
        $query = DB::table('rapport_visite')
            ->join('praticien', 'rapport_visite.id_praticien', '=', 'praticien.id_praticien')
            ->select(
                'rapport_visite.*',
                'praticien.nom_praticien',
                'praticien.prenom_praticien'
            );

        if ($nom) {
            $query->where('praticien.nom_praticien', 'like', '%' . $nom . '%');
        }

        if ($date) {
            $query->where('rapport_visite.date_rapport', '=', $date);
        }

        return $query->get();
    }


    public function getRapportById($id)
    {
        return DB::table('rapport_visite')
            ->where('id_rapport', $id)
            ->first();
    }


    public function saveRapport($data, $id_visiteur, $id_rapport = null)
    {
        if ($id_rapport) {
            DB::table('rapport_visite')
                ->where('id_rapport', $id_rapport)
                ->update([
                    'id_praticien' => $data['id_praticien'],
                    'date_rapport' => $data['date_rapport'],
                    'bilan'        => $data['bilan'],
                    'motif'        => $data['motif'],
                ]);
        } else {
            DB::table('rapport_visite')->insert([
                'id_visiteur'  => $id_visiteur,
                'id_praticien' => $data['id_praticien'],
                'date_rapport' => $data['date_rapport'],
                'bilan'        => $data['bilan'],
                'motif'        => $data['motif'],
            ]);
        }
    }


    public function getOffertsByRapport($id_rapport)
    {
        return DB::table('offrir')
            ->join('medicament', 'offrir.id_medicament', '=', 'medicament.id_medicament')
            ->select(
                'offrir.id_medicament',
                'offrir.id_rapport',
                'medicament.nom_commercial',
                'offrir.qte_offerte'
            )
            ->where('offrir.id_rapport', $id_rapport)
            ->get();
    }


    public function getOffert($id_rapport, $id_medicament)
    {
        return DB::table('offrir')
            ->where('id_rapport', $id_rapport)
            ->where('id_medicament', $id_medicament)
            ->first();
    }


    public function updateOffert($id_rapport, $id_medicament, $qte_offerte)
    {
        DB::table('offrir')
            ->where('id_rapport', $id_rapport)
            ->where('id_medicament', $id_medicament)
            ->update(['qte_offerte' => $qte_offerte]);
    }


    public function addOffert($id_rapport, $id_medicament, $qte_offerte)
    {
        DB::table('offrir')->insert([
            'id_rapport'    => $id_rapport,
            'id_medicament' => $id_medicament,
            'qte_offerte'   => $qte_offerte,
        ]);
    }


    public function deleteOffert($id_rapport, $id_medicament)
    {
        DB::table('offrir')
            ->where('id_rapport', $id_rapport)
            ->where('id_medicament', $id_medicament)
            ->delete();
    }


    public function getAllPraticiens()
    {
        return DB::table('praticien')->orderBy('nom_praticien')->get();
    }


    public function getAllMedicaments()
    {
        return DB::table('medicament')->get();
    }




    public function getRapportsByMedicament(int $idMedicament)
    {
        return DB::table('offrir')
            ->join('rapport_visite', 'offrir.id_rapport',      '=', 'rapport_visite.id_rapport')
            ->join('praticien',      'rapport_visite.id_praticien', '=', 'praticien.id_praticien')
            ->join('visiteur',       'rapport_visite.id_visiteur',  '=', 'visiteur.id_visiteur')
            ->where('offrir.id_medicament', $idMedicament)
            ->select(
                'rapport_visite.id_rapport',
                'rapport_visite.date_rapport',
                'rapport_visite.bilan',
                'rapport_visite.motif',
                'praticien.nom_praticien',
                'praticien.prenom_praticien',
                'visiteur.nom_visiteur',
                'visiteur.prenom_visiteur',
                'offrir.qte_offerte'
            )
            ->orderBy('rapport_visite.date_rapport', 'desc')
            ->get();
    }
}
