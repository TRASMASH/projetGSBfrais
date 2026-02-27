<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\VisiteurService;
class VisiteurController extends Controller{
    public function auth(Request $request){try{
        $login=$request->input('id');
        $pwd=$request->input('mdp');

        $service =new VisiteurService();
        if($service->signIn($login,$pwd)){
            return redirect(url('/'));
        }else{
            $erreur='Identifiant ou mot de passe incorrect';
            return view('/formLogin',compact('erreur'));
        }
    }catch (Exception $exception){
        return view('error',compact('exception'));
    }
    }
    public function login(){try {
        return view('formLogin');
    }catch (Exception $exception){
        return view('error',compact('exception'));
    }
    }


    public function logout()
    {try {
        $service = new VisiteurService();
        $service->signOut();
        return redirect(url('/'));
    }catch (Exception $exception){
        return view('error',compact('exception'));
    }
    }

}
