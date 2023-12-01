<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class AsociacionEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_asociacion";
  protected $primaryKey = "ID";
}

class AsociacionEmpleadoEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_asociacion_empleados";
  protected $primaryKey = "ID";
}


class Doc_asociacionEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_doc_asociacion";
  protected $primaryKey = "ID";
}