<?php

namespace App\Http\Controllers\Portal;

use App\AppUser;
use App\Hymn;
use App\Payment;
use App\UserSundaySchoolManual;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 11/4/20
 * Time: 6:52 PM
 */
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalAppUsers = AppUser::count();
        $totalSales = Payment::sum('amount');
        $totalHymns = Hymn::count();
        $numberOfCopiesBought = UserSundaySchoolManual::sum('copy');
        $groupedDccs = DB::table('app_users')
            ->select('dcc', DB::raw('count(*) as total'))
            ->groupBy('dcc')
            ->orderBy('total', 'DESC')
            ->get();
        $authToken = $user->api_token;
        $data = compact('authToken', 'user', 'totalAppUsers', 'totalSales', 'totalHymns', 'numberOfCopiesBought','groupedDccs');
        return view('portal.dashboard', $data);
    }
}
