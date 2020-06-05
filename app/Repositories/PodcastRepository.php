<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 5/13/20
 * Time: 4:06 AM
 */

namespace App\Repositories;


use App\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastRepository
{
    protected $errors;
    protected $s3Repository;

    public function __construct(S3Repository $s3Repository)
    {
        $this->errors = [];
        $this->s3Repository = $s3Repository;
    }

    public function new(Request $request)
    {

        $result = $this->upload($request);
        if (!$result) {
            return false;
        }

        $podcast = new Podcast();
        $podcast->topic_id = $request->topic;
        $podcast->media = $result;
        $podcast->save();
        return $podcast;
    }

    protected function upload(Request $request)
    {
        $isValid = $this->validateMedia($request);
        $media = $request->file('media');

        if (!$isValid) {
            return false;
        }
        $extension = $media->getClientOriginalExtension();

        $filename = 'podcast-' . time() . '.' . $extension;
        $path = $media->storeAs('files', $filename);

        $filePath = $this->s3Repository->upload($media, 'podcast');
        return $filePath;
    }

    private function validateMedia(Request $request)
    {
        if (!$request->file('media')) {
            array_push($this->errors, 'The media valid doesn\'t exist');
            return false;
        }
        $file = $request->file('media');
        if (!$file->isValid()) {
            array_push($this->errors, 'This media is invalid');
            return false;
        }
        return true;
    }

    public function download($id)
    {
        $podcast = Podcast::get($id);
        return $this->s3Repository->download($podcast->media);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
