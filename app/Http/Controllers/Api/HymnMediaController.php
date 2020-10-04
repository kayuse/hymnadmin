<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Hymn;
use App\HymnMedia;
use App\Repositories\HymnMediaRepository;
use App\Repositories\S3Repository;
use App\Repositories\HymnRepository;
use Illuminate\Http\Request;

class HymnMediaController extends Controller
{
    protected $repository;
    protected $s3Repository;

    public function __construct(HymnMediaRepository $repository, S3Repository $s3Repository)
    {
        $this->repository = $repository;
        $this->s3Repository = $s3Repository;
    }

    //
    public function list(Request $request, $hymnId)
    {
        try {
            $hymnAudio = HymnMedia::where('hymn_id', $hymnId)->get();
            return response()->json($hymnAudio);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function get(Request $request, $mediaId)
    {
        try {
            $hymnAudio = HymnMedia::find($mediaId);
            $hymnAudio->download_url = 'https://' . strtolower(env('DO_REGION')) . '.digitaloceanspaces.com/' . env('DO_BUCKET') . '/' . $hymnAudio->media;
            return response()->json($hymnAudio);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $media = $this->repository->addMedia($request);
            if ($media == false) {
                return response()->json($this->repository->getErrors());
            }
            return response()->json($media);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function download(Request $request, $id)
    {
        try {
            $hymnMedia = HymnMedia::find($id);
            $object = $this->s3Repository->download($hymnMedia->media);
            $mimeType = \GuzzleHttp\Psr7\mimetype_from_filename($hymnMedia->media);
            $response = \Response::make($object, 200);
            $response->header("Content-Type", $mimeType);
            return $response;

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
