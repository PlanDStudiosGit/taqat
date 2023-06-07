<?php
namespace App\Common;

class FileHandler{
    public static function uploadImage($file) {
        $ext = $file->extension();
        $path = public_path().'/uploads/';
        $prefix = 'uploads-' . md5(time().rand());
        $imgName = $prefix . '.' . $ext;
        if ($file->move($path, $imgName)) {
            return url('/')."/uploads/". $imgName;
        }else{
            return false;
        }
    }
}
