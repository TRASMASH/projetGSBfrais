<?php

namespace App\Services;
use App\Exceptions\UserException;
use App\Models\Etat;
use App\Models\Frais;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
class FraisService{
    public function getListFrais($id_visiteur){try {
        $liste = Frais::query()->where('id_visiteur', '=', $id_visiteur)->get();
        return $liste;
    }catch(QueryException $exception){
        $userMessage="Erreur d'aèes a la base de données";
        throw new UserException($userMessage,$exception->getMessage(),$exception->getCode());
    }
    }

    public function getFrais($id){try{
        $frais= Frais::query()->find($id);
        return $frais;}catch(QueryException $exception){
        $userMessage="Erreur d'aèes a la base de données";
        throw new UserException($userMessage,$exception->getMessage(),$exception->getCode());
    }
    }
    public function saveFrais($frais){try{
        $frais->save();
    }catch(QueryException $exception){
        $userMessage="Erreur d'aèes a la base de données";
        throw new UserException($userMessage,$exception->getMessage(),$exception->getCode());
    }
    }
    public function getListEtats(){
        try{
            return Etat::query()->get();
        }catch(QueryException $exception){
            $userMessage="Erreur d'aèes a la base de données";
            throw new UserException($userMessage,$exception->getMessage(),$exception->getCode());
        }
    }

    public function getFrais($id){
        return Frais::find($id);
    }

 public  function deleteFrais($id){
        $frais = Frais::find($id);
        $frais->delete();
 }
}

