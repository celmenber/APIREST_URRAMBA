<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;


class ParametricasEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_departamento";
  protected $primaryKey = "ID";
}

class MunicipioEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_municipio";
  protected $primaryKey = "ID";
}
class CorregimientoEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_corregimiento";
  protected $primaryKey = "ID";
}

class Veredas_barriosEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_veredas_barrios";
  protected $primaryKey = "ID";
}


class EscolaridadEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_escolaridad";
  protected $primaryKey = "ID";
}
class ParentescoEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_parentesco";
  protected $primaryKey = "ID";
}
class Orientacion_sexualEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_orientacion_sexual";
  protected $primaryKey = "ID";
}

class CargosEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_cargos";
  protected $primaryKey = "ID";
}

class LogoEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_logo";
  protected $primaryKey = "ID";
}