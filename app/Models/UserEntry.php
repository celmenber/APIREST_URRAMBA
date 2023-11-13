<?php
namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class UserEntry extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_login";
}

class UserEntryRoll extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_roll";
  protected $primaryKey = "ID";
}


class UserEntryPermiso extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_permiso";
  protected $primaryKey = "ID";
}

class UserEntryAcceso extends Model
{
  public $timestamps = false;
  protected $table = "tbl_user_acceso";
  protected $primaryKey = "ID";
}

class GT_user extends Model
{
  public $timestamps = false;
  protected $table = "tbl_gt_user";
  protected $primaryKey = "ID";
}
