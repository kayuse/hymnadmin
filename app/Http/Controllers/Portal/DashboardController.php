<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

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
        $authToken = $user->api_token;
        $data = compact('authToken', 'user');
        return view('portal.dashboard', $data);
    }
}
