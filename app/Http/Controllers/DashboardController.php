<?php

namespace App\Http\Controllers;

use App\Repositories\IHymnRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $repository;

    public function __construct(IHymnRepository $repository)
    {
        $this->repository = $repository;
    }

    //
    public function index()
    {
        $user = auth()->user();
        $authToken = $user->api_token;
        $data = compact('authToken','user');
        return view('layout_dashboard', $data);
    }

    public function getStats()
    {
        try {
            $response = $this->repository->getStats();
            return response()->json(['status' => 1, 'data' => $response], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => -1, 'message' => 'Invalid Request'], 500);
        }
    }
}
