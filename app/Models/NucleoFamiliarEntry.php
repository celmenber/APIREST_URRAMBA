<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class NucleoFamiliarEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_nucleo_familiar";
  protected $primaryKey = "ID";
}