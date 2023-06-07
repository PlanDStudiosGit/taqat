<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditorUploadsController extends Controller
{
    public function upload(Request $request) {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return response()->json(array (
                "status" => "error",
                "location" => $error[0]
            ));
        }else {
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                if ($file->isValid()) {
                    $imgName = FileHandler::uploadImage($file);
                    if ($imgName) {
                        return response()->json(array (
                            "status" => "success",
                            "location" => $imgName
                        ));
                    }else{
                        return response()->json(array (
                            "status" => "error",
                            "location" => "Something went wrong"
                        ));
                    }
                }else {
                    return response()->json(array (
                        "status" => "error",
                        "location" => "Something went wrong"
                    ));
                }
            }
        }
    }
}
