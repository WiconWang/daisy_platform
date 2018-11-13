<?php

namespace App\Models\Channels;

use Illuminate\Database\Eloquent\Model;

class InfoModel extends Model
{
    protected $table = 'channels';
    protected $fillable = ['fid', 'status', 'title', 'description',  'weight'];

}
