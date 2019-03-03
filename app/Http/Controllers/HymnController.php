<?php

namespace App\Http\Controllers;

use App\Repositories\IHymnRepository;
use Illuminate\Http\Request;
use Validator;


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
            $response = $this->respository->saveHymn($data, $recordId);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }

    public function get($id)
    {
        try {

            return response()->json(['success' => 1, 'data' => $hymn]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }

    public function new(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'number' => 'required|integer',
                'extra' => 'required'
            ]);
            $data = $this->respository->new($request->all());
            return response()->json(['status' => 1, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }
}
