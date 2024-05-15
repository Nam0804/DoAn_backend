<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedImage = $request->file('upload');
        $name = md5_file($uploadedImage->getRealPath()) . '.' . $uploadedImage->getClientOriginalExtension();
        $filename = $uploadedImage->move(public_path('/bloguploadimg'), $name);
        return response()->json(['url' => asset('bloguploadimg/'.$filename->getFilename() )]);
    }
    public function delete()
    {

    }
}
