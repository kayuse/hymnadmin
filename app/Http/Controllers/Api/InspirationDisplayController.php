<?php

namespace App\Http\Controllers\Api;

use App\InspirationDisplay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InspirationDisplayController extends Controller
{

    public function getTodaysInspiration() {
        // get inspiration
        $inspiration = InspirationDisplay::with('inspiration')
            ->where('date_added', Carbon::today()->toDateString())
            ->first();

        return response()->json([
            'success' => true,
            'data' => $inspiration
        ], 200);
    }
}
