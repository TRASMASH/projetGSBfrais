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
    return view('formFrais');
}

public function validFrais(Request $request){
    $frais=new Frais();
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

}
