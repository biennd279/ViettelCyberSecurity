<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function upload(UploadedFile $uploadedFile, string $path_dir = '')
    {
        if ($path_dir == '')
        {
            $path_dir = '/'.md5($uploadedFile->getClientOriginalName().time());
        }

        $path = Storage::putFileAs('public'.$path_dir, $uploadedFile,
            $uploadedFile->getClientOriginalName());
        $file = new File([
            'path' => $path
        ]);
        $file->save();
        return $file;
    }

    public static function download(File $file)
    {
        return Storage::url($file->path);
    }

    public static function delete(File $file)
    {
        Storage::delete($file->path);
    }

    public static function get(File $file)
    {
        Storage::get($file->path);
    }
}
