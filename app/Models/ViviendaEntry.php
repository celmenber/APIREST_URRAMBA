<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;


class ViviendaEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_inmueble";
  protected $primaryKey = "ID";
}


class EnceresEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_enceres";
  protected $primaryKey = "ID";
}

class ImgInmuebleEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_img_inmueble";
  protected $primaryKey = "ID";
}