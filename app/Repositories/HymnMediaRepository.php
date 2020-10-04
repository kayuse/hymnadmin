<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 6/5/20
 * Time: 10:30 AM
 */

namespace App\Repositories;


use App\HymnMedia;
use Illuminate\Http\Request;

class HymnMediaRepository
{
    protected $s3Repository;
    protected $errors = [];

    public function __construct(S3Repository $s3Repository)
    {
        $this->s3Repository = $s3Repository;
    }

    public function addMedia($request)
    {
        $result = $this->upload($request);
        if (!$result) {
            return false;
        }
        $hymnMedia = new HymnMedia();
        $hymnMedia->hymn_id = $request->hymn;
        $hymnMedia->media = $result;
        $hymnMedia->save();

        return $hymnMedia;
    }

    protected function upload(Request $request)
    {
        $isValid = $this->validateMedia($request);
        $media = $request->file('media');

        if (!$isValid) {
            return false;
        }

        $extension = $media->getClientOriginalExtension();
        $filename = 'hymn-' . time() . '.' . $extension;

        $filePath = $this->s3Repository->upload($media, $filename, 'hymns');
        return $filePath;
    }

    private function validateMedia(Request $request)
    {
        if (!$request->file('media')) {
            array_push($this->errors, 'The media valid doesn\'t exist');
            dd('error1');
            return false;
        }
        $file = $request->file('media');
        if (!$file->isValid()) {
            array_push($this->errors, 'This media is invalid');
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
