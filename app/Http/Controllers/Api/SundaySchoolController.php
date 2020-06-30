<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Podcast;
use App\Repositories\PodcastRepository;
use App\Repositories\S3Repository;
use App\Repositories\SundaySchoolRepository;
use Illuminate\Http\Request;

class SundaySchoolController extends Controller
{
    protected $repository;
    protected $podcastRepository;
    protected $s3Repository;

    //
    public function __construct(SundaySchoolRepository $repository, PodcastRepository $podcastRepository, S3Repository $s3Repository)
    {
        $this->repository = $repository;
        $this->podcastRepository = $podcastRepository;
        $this->s3Repository = $s3Repository;
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

    public function getTopic(Request $request, $id)
    {
        try {
            $data = $this->repository->topic($id);
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
