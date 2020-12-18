<?php

namespace App\Http\Controllers;

use App\Repositories\S3Repository;
use Illuminate\Http\Request;

class S3Controller extends Controller
{
    protected $repository;

    public function __construct(S3Repository $repository)
    {
        $this->repository = $repository;
    }

    //
    public function download(Request $request, $file)
    {
        $file = base64_decode($file);
        $object = $this->repository->download($file);
        $mimeType = \GuzzleHttp\Psr7\mimetype_from_filename($file);
        $response = \Response::make($object, 200);
        $response->header("Content-Type", $mimeType);
        return $response;
    }
}
