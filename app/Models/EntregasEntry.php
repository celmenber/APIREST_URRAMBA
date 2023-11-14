<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;


class EntregasEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_entrega_articulos";
  protected $primaryKey = "ID";
}


class EvintregajefehEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_evi_entrega_jefeh";
  protected $primaryKey = "ID";
}