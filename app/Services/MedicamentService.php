<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MedicamentService
{

    public function getAllMedicaments()
    {
        return DB::table('medicament')
            ->select('id_medicament', 'nom_commercial')
            ->orderBy('nom_commercial')
            ->get();
    }
}
