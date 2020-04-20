<?php

namespace App\Http\Controllers\Api;

use App\Repositories\IHymnRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HymnListController extends Controller
{
    protected $repository;
    public function __construct(IHymnRepository $repository)
    {
        $this->repository = $repository;
    }
    public function all(){
        try {
            $hymn =  $this->repository->userHymns(auth()->user());
            return response()->json(['data' => $hymn]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }

    public function get($id )
    {
        try {
            $hymn =  $this->repository->show($id);
            return response()->json(['success' => 1, 'data' => $hymn]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }
    //
    public function details($number)
    {
        try {
            $hymn = $this->repository->getHymn($number);
            return response()->json(['success' => 1, 'data' => $hymn]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }
}
