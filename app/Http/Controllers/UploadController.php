<?php

namespace App\Http\Controllers;

use App\Infastructures\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class UploadController extends Controller
{
    protected $response;

    public function __construct(
        Response $response)
    {
        $this->response = $response;
    }

    public function uploadEventImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $uniqueFilename = uniqid() . '_' . $image->getClientOriginalName();
            $path = 'events/images/' . $uniqueFilename;

            // Store the image on the FTP server with a unique filename
            Storage::disk('ftp')->put($path, file_get_contents($image));
            
            return $this->response->successResponse("success upload image ", null);
        }

        return $this->response->errorResponse("failed upload image");
    }
}