<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Podcast;
use App\Repositories\PodcastRepository;
use App\Repositories\S3Repository;
use App\Repositories\SundaySchoolRepository;
use App\RequestCopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function paidManuals(Request $request)
    {
        try {
            $data = $this->repository->getPaidManuals(auth()->user()->id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function requestCopy(Request $request)
    {
        $validatedData = $request->validate([
            'manual_id' => 'required|integer'
        ]);
        $user = Auth::user();
        $copy = RequestCopy::where('user_id', $user->id)
            ->where('reference_id', $request->manual_id)->where('copy_reference', 'sunday_school_manual')->first();
        if ($copy != null) {
            return response()->json(['message' => 'You have requested a copy previously'], 401);
        }

        try {
            $data = $this->repository->createRequestCopy($user->id, $request->manual_id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function unpaid(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $data = $this->repository->getUnpaidManuals($userId);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function pay(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'reference' => 'required|string',
                'amount' => 'required|integer',
                'manual_id' => 'required|integer',
                'copy' => 'required|integer',
            ]);
            $data = $request->all();
            $user = auth()->user();
            $data = $this->repository->pay($data, $user);
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
