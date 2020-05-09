<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\InspirationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class InspirationController extends Controller
{
    protected $repository;

    public function __construct(InspirationRepository $inspirationRepository)
    {
        $this->repository = $inspirationRepository;
    }

    public function index()
    {
        try {
            $data = $this->repository->all();
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validate->error()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $array = array(['title' => $request->input('title'), 'description' => $request->input('description'), 'link' => $request->input('link')]);
        try {
            $data = $this->repository->create($array);
            return response()->json(['data' => $data, 'status' => true], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'failed',
                'status' => false
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required'
        ]);

        $array = array(['title' => $request->input('title'), 'description' => $request->input('description'), 'link' => $request->input('link')]);

        try {
            $data = $this->repository->update($array, $id);
            return response()->json(['data' => $data, 'status' => true], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            $data = $this->repository->update($array, $id);

            return response()->json(['message' => $data, 'status' => false], 500);
        }
    }

    public function get($id)
    {
        try {
            $data = $this->repository->show($id);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function delete($id)
    {

        try {
            $data = $this->repository->delete($id);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed', 'status' => false], 500);
        }
    }
}
