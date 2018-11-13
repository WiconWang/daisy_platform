<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class InfoModel extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

//    protected $connection = 'mysql_admin';
    protected $table = 'users_info';
    public $timestamps = false;
}
