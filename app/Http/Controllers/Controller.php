<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function home(){try{

        return view('home');
    }catch (Exception $exception){
        return view('error',compact('exception'));
    }
    }
}
