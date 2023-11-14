<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class ConcejocomunitarioEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_conncejos_comunitarios";
  protected $primaryKey = "ID";
}
class ConcejosmiembrosEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_concejos_miembros";
  protected $primaryKey = "ID";
}

class Autoridad_tradicionalEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_autoridad_tradicional";
  protected $primaryKey = "ID";
}