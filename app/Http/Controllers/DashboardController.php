<?php

namespace App\Http\Controllers;

use App\Repositories\HymnRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $repository;
    public function __construct(HymnRepository $repository)
    {
        $this->repository = $repository;
    }

    //
    public function index(){
        $user = auth()->user();
        $authToken = $user->api_token;
        $data = compact('authToken');
        return view('layout_dashboard',$data);
    }

    public function getStats(){

    }
}
