<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\LaborModel;
use App\Models\LaborTransferModel;
use App\Models\User;
use Illuminate\Support\Str;

class TestingController extends Controller
{
    public function testing()
    {
      return LaborTransferModel::all();
    }
}
