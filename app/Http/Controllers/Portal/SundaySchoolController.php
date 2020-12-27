<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Repositories\PodcastRepository;
use App\Repositories\SundaySchoolRepository;
use App\SundaySchoolManual;
use App\SundaySchoolTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SundaySchoolController extends Controller
{
    protected $repository;
    protected $podcastRepository;

    public function __construct(SundaySchoolRepository $repository, PodcastRepository $podcastRepository)
    {
        $this->repository = $repository;
        $this->podcastRepository = $podcastRepository;
    }

    //
    public function index(Request $request)
    {
        $manuals = SundaySchoolManual::all();
        $data = compact('manuals');
        return view('portal.sundayschool.manuals', $data);
    }

    public function details(Request $request, $id)
    {
        $topic = SundaySchoolTopic::find($id);
        $data = compact('topic');
        return view('portal.sundayschool.details', $data);
    }

    public function manuals(Request $request, $id)
    {
        $manual = SundaySchoolManual::find($id);
        $data = compact('manual');
        return view('portal.sundayschool.topics', $data);
    }

    public function new(Request $request)
    {
        return view('portal.sundayschool.new_manual');
    }

    public function editTopic(Request $request, $id)
    {
        $topic = SundaySchoolTopic::find($id);
        $data = compact('topic');
        return view('portal.sundayschool.edit', $data);
    }

    public function postEditTopic(Request $request, $id)
    {
        $validatedData = $request->validate([
            'aim' => 'required|string',
            'topic' => 'required|string',
            'number' => 'required|integer',
            'bible_text' => 'required|string',
            'category' => 'required|string',
            'introduction' => 'required|string',
            'content' => 'required|string'
        ]);
        $data = $request->all();
        $topic = $this->repository->editSundaySchool($id, $data);
        return redirect(route('portal.sundayschool.topic.details', ['id' => $id]))->with('success', 'Edit Successful');
    }

    public function newTopic(Request $request, $id)
    {
        $manual = SundaySchoolManual::find($id);
        $data = compact('manual');
        return view('portal.sundayschool.new_topic', $data);
    }

    public function postNewTopic(Request $request, $id)
    {
        $validatedData = $request->validate([
            'aim' => 'required|string',
            'topic' => 'required|string',
            'number' => 'required|integer',
            'bible_text' => 'required|string',
            'category' => 'required|string',
            'introduction' => 'required|string',
            'content' => 'required|string'
        ]);
        $data = $request->all();
        $data['manual_id'] = $id;
        $topic = $this->repository->newTopic($data);
        return redirect(route('portal.sundayschool.topic.details', ['id' => $topic->id]))->with('success', 'Successfully created lesson');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'year' => 'required|integer',
            'language' => 'required|string',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $manual = $this->repository->newManual($data);
        if ($manual != null) {
            return redirect(route('portal.sundayschool.all'))->with('success', 'You have successfully created this Sunday School Manual');
        }
        return back()->with('error', 'Error in running updates, kindly try again or contact support admin');
    }

    public function viewPodcastUpload($id)
    {
        $topic = SundaySchoolTopic::find($id);
        $data = compact('topic');
        return view('portal.sundayschool.upload', $data);
    }

    public function podcastUpload(Request $request, $id)
    {
        try {
            $request->topic = $id;
            $podcast = $this->podcastRepository->new($request);
            if (!$podcast) {
                return back()->with('error', 'Error in uploading podcast, kindly try again or contact support admin');
            }
            return redirect(route('portal.sundayschool.all'))->with('success', 'You have successfully upload a podcast for this session');
        } catch (\Exception $e) {
            return back()->with('error', 'Error in uploading podcast, kindly try again or contact support admin');
        }
    }
}
