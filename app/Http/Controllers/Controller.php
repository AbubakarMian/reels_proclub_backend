<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\libraries;
use App\libraries\Common;
use App\libraries\APIResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs,Common,APIResponse, ValidatesRequests;
}
