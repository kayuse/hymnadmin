<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\HymnDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HymnDownloadController extends Controller
{
    //
    public function upload(Request $request)
    {if ($request->hasFile('hymn')) {
            $file = $request->file('hymn');
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFileName = time() . strtolower(preg_replace('/\s/', '', $request->input('number'))) . $request->input('ugFormId') .
                '.' . $extension;
            $store = Storage::disk('spaces')->put('/hymns/' . $newFileName, file_get_contents($request->file('hymn')->getRealPath()), 'public');

            $uploaded = HymnDownload::create(['number' => $request->input('number'), 'version' => $request->input('version'), 'file' => $newFileName]);

            return response()->json(['message' => $uploaded, 'status' => true]);
        }
        return response()->json(['message' => 'failed', 'status' => false]);
    }

    public function getFile($hymn, $version)
    {
        $found = HymnDownload::where('number', $hymn)->where('version', $version)->first();
//        $file = Storage::disk('spaces')->get('hymns/' . $found['file']);
//        $header = ['Content-type' => 'audio/mp3'];
        return response()->json(['message'=>$found, 'status'=> true]);
    }
}
