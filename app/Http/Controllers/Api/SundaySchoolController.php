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
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
