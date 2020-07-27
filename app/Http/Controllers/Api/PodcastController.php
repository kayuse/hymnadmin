<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Podcast;
use App\Repositories\PodcastRepository;
use App\Repositories\S3Repository;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    protected $s3Repository;
    protected $podcastRepository;

    public function __construct(S3Repository $s3Repository, PodcastRepository $repository)
    {
        $this->s3Repository = $s3Repository;
        $this->podcastRepository = $repository;
    }

    //
    public function addPodcast(Request $request)
    {
        try {
            $podcast = $this->podcastRepository->new($request);
            if (!$podcast) {
                return response()->json($this->podcastRepository->getErrors(), 401);
            }
            return response()->json($podcast);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getPodCastMedia(Request $request, $podcastId)
    {
        try {
            $podcast = Podcast::where('topic_id', $podcastId)->first();
            if ($podcast == null) {
                return response()->json($podcast);
            }
            $podcast->media_url = 'https://' . strtolower(env('DO_REGION')) . '.digitaloceanspaces.com/' . env('DO_BUCKET') . '/' . $podcast->media;
            return response()->json($podcast);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function downloadPodCast(Request $request, $id)
    {

        try {
            $file = Podcast::where('topic_id', $id)->first()->media;
            $object = $this->s3Repository->download($file);
            $mimeType = \GuzzleHttp\Psr7\mimetype_from_filename($file);
            $response = \Response::make($object, 200);
            $response->header("Content-Type", $mimeType);
            return $response;

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
