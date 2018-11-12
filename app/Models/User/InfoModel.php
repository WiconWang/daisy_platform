<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class InfoModel extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;

//    protected $connection = 'mysql_admin';
    protected $table = 'user_info';
    public $timestamps = false;
}
