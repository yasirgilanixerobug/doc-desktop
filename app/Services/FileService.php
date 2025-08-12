<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FileService
{
    /**
     * @param $publicPath
     * @param $file
     * @return string
     */
    public function uploadImage ($publicPath, $file): string
    {
        $imageName = $file->hashName(); // Generate a unique, random name...

        $imageDir = public_path().$publicPath;
        $filePath = $publicPath.$imageName;
        $file->move($imageDir, $imageName);

        return $filePath;
    }
}
