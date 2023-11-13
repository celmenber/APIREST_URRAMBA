<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LoginEntry extends Model
{
    protected $table = 'tbl_user_login';
    protected $fillable = ["USERNAME","PASSWORD"];
}