<?php
namespace App\Http\Controllers;
use App\Models\Frais;
use Illuminate\Http\Request;
use App\Services\FraisService;

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

}
