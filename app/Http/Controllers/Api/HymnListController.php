<?php

namespace App\Http\Controllers\Api;

use App\Hymn;
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

    public function all($language = null)
    {
        try {
            if ($language == null) {
                $hymns = $this->repository->userHymns(auth()->user());
            } else {
                $hymns = Hymn::where('language', $language)->with('verses')->orderBy('number', 'asc')->get();
            }
            return response()->json($hymns);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function get($id)
    {
        try {
            $hymn = $this->repository->show($id);
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

    public function categories()
    {
        try {
            $categories = $this->repository->categories(auth()->user());
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
