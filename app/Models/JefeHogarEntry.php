<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class JefeHogarEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_jefe_hogar";
  protected $primaryKey = "ID";
}
