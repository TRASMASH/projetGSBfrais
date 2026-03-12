<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Frais extends Model{

    protected  $table='rapports_visite';
    protected $primaryKey ='id_rapport';
    public $timestamps = false;

}
