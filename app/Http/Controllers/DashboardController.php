<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $user = auth()->user();
        $authToken = $user->api_token;
        $data = compact('authToken');
        return view('layout_dashboard',$data);
    }
}
