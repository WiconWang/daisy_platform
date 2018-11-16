<?php

namespace App\Models\Component;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $fillable = ['classification', 'title', 'short_title', 'description', 'link_url', 'status', 'pic_url', 'out_date'];

}
