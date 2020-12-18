<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 12/5/19
 * Time: 4:07 AM
 */

namespace App\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class S3Repository
{
    const FILES_FOLDER = 'files';
    protected $name;
    protected $key;
    protected $secret;
    protected $space;

    public function __construct()
    {
        $this->key = env('DO_KEY');
        $this->name = env('DO_BUCKET');
        $this->secret = env('DO_SECRET');
        $this->region = env('DO_REGION');

        $this->space = new \SpacesConnect($this->key, $this->secret, $this->name, $this->region);
    }

    public function upload(UploadedFile $file, $filename, $folder)
    {
        if (App::environment('local')) {
            // return $file;
        }

        $filepath = $folder . '/' . $filename;
        $this->space->UploadFile($file, 'public', $filepath);
        return $filepath;
    }

    public function get($file)
    {
        try {
            return $this->space->GetObject($file);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function download($file)
    {
        return $this->space->DownloadFile($file);
    }

}
