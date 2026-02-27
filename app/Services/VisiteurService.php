<?php
namespace App\Services;



use App\Models\Visiteur;

use Illuminate\Support\Facades\Session;

class VisiteurService
{

    public function signIn($login, $pwd)
    {
        try {
            $visiteur = Visiteur::query()->where('login_visiteur', '=', $login)->first();

            //if ($visiteur && $visiteur->pwd_visiteur == $pwd) {
            if ($visiteur && password_verify($pwd, $visiteur->pwd_visiteur)) {
                Session::put('id_visiteur', $visiteur->id_visiteur);
                Session::put('visiteur', "$visiteur->prenom_visiteur $visiteur->nom_visiteur");
                return true;
            }}catch (\Exception $e){
        return false;
        }
    }


    public function signOut()
    {
        Session::remove('id_visiteur');
    }



}


