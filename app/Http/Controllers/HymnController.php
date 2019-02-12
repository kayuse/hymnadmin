<?php

namespace App\Http\Controllers;

use App\Repositories\IHymnRepository;
use Illuminate\Http\Request;

class HymnController extends Controller
{
    //
    protected $respository;

    public function __construct(IHymnRepository $repository)
    {
        $this->respository = $repository;
    }

    public function createHymn(Request $request)
    {
        try {
            $hymn = $request->hymn;
            $recordId = $request->record_id;
            $data = $hymn;
            $response = $this->respository->saveHymn($data,$recordId);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() . $e->getTrace(), 'status' => -1], 500);
        }
    }
}
