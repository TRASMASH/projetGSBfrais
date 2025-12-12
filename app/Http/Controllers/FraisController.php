<?php
namespace App\Http\Controllers;
use App\Models\Frais;
use Illuminate\Http\Request;
use App\Services\FraisService;
use Illuminate\Support\Facades\Auth;

class FraisController extends Controller
{ public function listFrais()
{
    $service = new FraisService();
    $id_visiteur= session('id_visiteur');
    $fiches=$service->getListFrais($id_visiteur);
    return view('listFrais',compact('fiches'));
}

public function addFrais(){
    $frais = new Frais();
    $frais->anneemois=date("T-m");

    return view('formFrais',compact('frais') );
}

public function validFrais(Request $request){
    $frais=new Frais();
    $id_frais=$request->input('id');
    $frais->id_visiteur =session('id_visiteur');
    $frais->anneemois= $request->input('mois');
    $frais->nbjustificatifs= $request->input('nbjustif');
    $frais->montantvalide= $request->input('valide');
    $frais->id_etat=$request->input('etat');
    $frais->datemodification =date("Y-m-d");


    $service = new FraisService();
    $service->saveFrais($frais);
    return redirect(url('/listerFrais'));
}
public function saveFrais($frais){
    $frais->save();
}
public function editFrais($id){
    $service = new FraisService();
    $frais =$service->getFrais($id);
    return view('editFrais',compact('frais'));
}
public function getFrais($id){
    $frais= Frais::query()->find($id);
    return $frais;
}
public function getFraisAPI($idFrais){
  try{
      $service = new FraisService();
      $frais =$service->getFrais($idFrais);
      return json_encode($frais);
  }catch(Exception $e){
      $erreur=$e->getMessage();
      return reponse()->json(['erreur'=>$erreur],500);
  }
}
    public function addFraisAPI(Request $request)
    {





        $frais = new Frais();
        $frais->anneemois = $request->json('anneemois');
        $frais->id_visiteur = $request->json('id_visiteur');
        $frais->nbjustificatifs = $request->json('nbjustificatifs');
        $frais->datemodification = date("Y-m-d");
        $frais->montantvalide = 0;
        $frais->id_etat = 1;

        $service = new FraisService();
        $service->saveFrais($frais);

        return response()->json([
            "message" => "Insertion réalisée",
            "id_frais" => $frais->id_frais
        ]);
    }

        public function updateFraisAPI(Request $request) {
            $service = new FraisService();
            $idFrais = $request->input('id_frais');
            $frais = $service->getFrais($idFrais);






            if($request->has('anneemois')) $frais->anneemois = $request->json('anneemois');
            if($request->has('nbjustificatifs')) $frais->nbjustificatifs = $request->json('nbjustificatifs');
            if($request->has('montantvalide')) $frais->montantvalide = $request->json('montantvalide');
            if($request->has('id_etat')) $frais->id_etat = $request->json('id_etat');

            $frais->datemodification = date("Y-m-d");

            $service->saveFrais($frais);

            return response()->json([
                "message" => "Modification réalisée",
                "id_frais" => $frais->id_frais
            ]);
        }
    public function removeFraisAPI(Request $request) {
        $service = new FraisService();
        $idFrais = $request->input('id_frais');
        $frais = $service->getFrais($idFrais);

        $service->deleteFrais($idFrais);

        return response()->json([
            "message" => "Suppression réalisée",
            "id_frais" => $idFrais
        ]);
    }



}
