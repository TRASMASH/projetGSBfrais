<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Visiteur;
use Exception;
use Illuminate\Http\Request;
use App\Services\VisiteurService;
class VisiteurController extends Controller{
    public function auth(Request $request){
        $login=$request->input('id');
        $pwd=$request->input('mdp');

        $service =new VisiteurService();
        if($service->signIn($login,$pwd)){
            return redirect(url('/'));
        }else{
            $erreur='Identifiant ou mot de passe incorrect';
            return view('/formLogin',compact('erreur'));
        }
    }
    public function login(){
        return view('formLogin');
    }


    public function logout()
    {
        $service = new VisiteurService();
        $service->signOut();
        return redirect(url('/'));
    }
    public function initPasswordAPI(Request $request)
    {
        try {
            $request->validate(['pwd_visiteur' => 'required|min:3']);
            $hash = bcrypt($request->json('pwd_visiteur'));
            Visiteur::query()->update(['pwd_visiteur' => $hash]);
            return response()->json(['status' => 'mots de passe réinitialisés']);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

        public function authAPI(Request $request)
    {
        try {
            $request->validate([
                'login' => 'required',
                'pwd' => 'required'
            ]);
            $login = $request->json("login");
            $pwd = $request->json("pwd");
            $identifiants = ['login_visiteur' => $login, 'password' => $pwd];
            if (!Auth::attempt($identifiants)) {
                return response()->json(['error' => 'Identifiants incorrects'], 401);
            }

            $visiteur = $request->user();
            $token = $visiteur->createToken('authToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'visiteur' => [
                    'id_visiteur' => $visiteur->id_visiteur,
                    'nom_visiteur' => $visiteur->nom_visiteur,
                    'prenom_visiteur' => $visiteur->prenom_visiteur,
                    'type_visiteur' => $visiteur->type_visiteur,
                ]
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function logoutAPI(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['status' => 'utilisateur déconnecté']);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function unauthorizedAPI()
    {
        return response()->json(['error' => 'accès non autorisé'], 401);
    }



}
