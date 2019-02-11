<?php

namespace App\Http\Controllers;

use App\Repositories\IRecordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;

class RecordController extends Controller
{
    //
    private $repository;

    public function __construct(IRecordRepository $repository)
    {
        $this->repository = $repository;
    }

    public function add(Request $request)
    {
        $data = $request->data;
        try {
            $ids = $this->repository->newRecord($data);
            return response()->json(['ids' => $ids, 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }

    public function get($id)
    {
        try {
            $record = $this->repository->show($id);
            return response()->json(['status' => true, 'data' => $record]);
        } catch (Exception $e) {
            return response("", 500)->json(['status' => false, 'message' => 'Error in processing request']);
        }
    }

    public function fetch(Request $request)
    {
        $page = $request->page != null ?: 1;

        $result = $this->repository->fetch($page);

        return response()->json(['data' => $result, 'status' => true]);
    }
}
