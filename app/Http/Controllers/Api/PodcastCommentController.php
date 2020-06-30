<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Podcast;
use App\PodcastComment;
use App\Repositories\PodcastRepository;
use Illuminate\Http\Request;

class PodcastCommentController extends Controller
{
    protected $podcastRepository;

    public function __construct(PodcastRepository $repository)
    {
        $this->podcastRepository = $repository;
    }

    public function addComment(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'user_id' => 'required|integer',
                'podcast_id' => 'required|integer',
                'text' => 'required'
            ]);
            $comment = $this->podcastRepository->addComment($request);

            return response()->json($comment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getComments($id)
    {
        try {

            $comments = PodcastComment::where('podcast_id', $id)->with('user')->get();

            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
