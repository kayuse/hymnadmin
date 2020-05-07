<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SundaySchoolRepository;
use Illuminate\Http\Request;

class SundaySchoolController extends Controller
{
    protected $repository;

    //
    public function __construct(SundaySchoolRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(Request $request)
    {
        try {
            $data = $this->repository->all();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function categories(Request $request)
    {
        try {
            $data = $this->repository->categories();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
