<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class CaracterizacionEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_caracterizacion";
  protected $primaryKey = "ID";
}