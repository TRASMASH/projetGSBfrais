<?php

namespace App\Services;
use App\Models\Frais;




use Illuminate\Support\Facades\Session;
class FraisService{
    public function getListFrais($id_visiteur){
        $liste= Frais::query()->where('id_visiteur','=',$id_visiteur)->get();
        return $liste;
    }
    public function saveFrais($frais,){



        $frais->save();
    }
}

