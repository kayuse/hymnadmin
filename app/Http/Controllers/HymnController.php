<?php

namespace App\Http\Controllers;

use App\Repositories\IHymnRepository;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;use Validator;


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

    public function getHymn($number)
    {
        try {
            $hymn = $this->respository->getHymn($number);
            return response()->json(['success' => 1, 'data' => $hymn]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }
    public function download(){
        try {
            $hymns = $this->respository->all();
            return response()->json(['data' => $hymns]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }

    public function getUnfilledHymns(){
        try{
            $unfilledHymns = $this->respository->getUnfilledHymnNumbers();
            return response()->json(['data'=>$unfilledHymns]);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage(), 'status' => -1], 500);
        }
    }

    public function get($id )
    {
        try {
           $hymn =  $this->respository->show($id);
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
