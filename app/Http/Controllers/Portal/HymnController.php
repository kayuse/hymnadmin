<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Hymn;
use App\Repositories\HymnMediaRepository;
use App\Repositories\IHymnRepository;
use App\Repositories\S3Repository;
use Illuminate\Http\Request;

class HymnController extends Controller
{
    const COUNT = 50;
    protected $repository;
    protected $mediaRepository;
    protected $s3Repository;

    public function __construct(IHymnRepository $repository, S3Repository $s3Repository, HymnMediaRepository $mediaRepository)
    {
        $this->repository = $repository;
        $this->mediaRepository = $mediaRepository;
        $this->s3Repository = $s3Repository;
    }

    //
    public function index(Request $request)
    {
        $hymns = Hymn::paginate(self::COUNT);
        $data = compact('hymns');
        return view('portal.hymns.hymns', $data);
    }

    public function details(Request $request, $id)
    {
        $hymn = Hymn::find($id);
        $data = compact('hymn');
        return view('portal.hymns.details', $data);
    }

    public function viewNew(Request $request)
    {
        return view('portal.hymns.new');
    }
    public function new(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string',
            'number' => 'required|integer',
            'language' => 'required|string',
            'extra' => 'required',
        ]);

        $hymn = $this->repository->newHymn($request->all());
        if ($hymn != null) {
            return redirect(route('portal.hymns.details', ['id' => $hymn->id]))->with('success', 'You have successfully created this hymn');
        }
        return back()->with('error', 'Error in running edits, kindly try again or contact support admin');
    }
    public function viewEdit(Request $request, $id)
    {
        $hymn = Hymn::find($id);
        $data = compact('hymn');
        return view('portal.hymns.edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'number' => 'required|integer',
            'language' => 'required|string',
            'extra' => 'required',
        ]);
        $result = $this->repository->edit($id, $request->all());
        if ($result != null) {
            return redirect(route('portal.hymns.details', ['id' => $id]))->with('success', 'Edit successful');
        }
        return back()->with('error', 'Error in running edits, kindly try again or contact support admin');
    }

    public function viewUpload(Request $request, $id)
    {
        $hymn = Hymn::find($id);
        $data = compact('hymn');
        return view('portal.hymns.upload', $data);
    }

    public function upload(Request $request, $id)
    {
        try {
            $request->hymn = $id;
            $media = $this->mediaRepository->addMedia($request);
            if ($media == false) {
                $errors = $this->mediaRepository->getErrors();
                return back()->with('error', implode(',', $errors));
            }
            return redirect(route('portal.hymns.details', ['id' => $request->hymn]))->with('success', 'Upload successful');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function verses(Request $request, int $id)
    {

    }
}
