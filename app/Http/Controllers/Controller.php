<?php

namespace App\Http\Controllers;

use App\Utilities\ResponseHelper;
use App\Utilities\ReturnCodeHelper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ReturnCodeHelper, ResponseHelper;

}
