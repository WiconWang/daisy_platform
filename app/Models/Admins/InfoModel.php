<?php

namespace App\Models\Admins;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class InfoModel extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

//    protected $connection = 'mysql_admin';
    protected $table = 'admins_info';
    protected $fillable = ['username','mobile','email','password','cover','level','status','out_date'];
    public $timestamps = false;
}



