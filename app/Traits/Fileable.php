<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Fileable {

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


    public function explodeFileName($delimiter, $filePath): string
    {
        return explode($delimiter, $filePath)[1];
    }

    /**
     * @param $requestIns
     * @return array
     */
    public function storeInsuranceDoc($requestIns, $userId = ''): array
    {
        $userId = (Auth::user()) ? Auth::user()->id : $userId;
        $insPath  = 'upload/insurance/'.$userId.'/';
        $attachUploadFilePathsForEmail = [];
        $attachUploadFilePathsForDb = [];

        if (isset($requestIns['ins_front'])) {

            $file = $requestIns['ins_front'];
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = $insPath.$name;
            
            //$storeFileName  = $this->uploadImage($insPath, $file);
            //array_push($attachUploadFilePaths, ['ins_front' => $storeFileName]);
            $attachUploadFilePathsForDb = array_merge($attachUploadFilePathsForDb, ['ins_front' => $name]);
            $attachUploadFilePathsForEmail = array_merge($attachUploadFilePathsForEmail, ['ins_front' => public_path().'/'.$name]);
        }

        if (isset($requestIns['ins_back'])) {
            $file = $requestIns['ins_back'];

            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = $insPath.$name;
            
            //$storeFileName  = $this->uploadImage($insPath, $file);
            //array_push($attachUploadFilePaths, ['ins_back' => $storeFileName]);
            $attachUploadFilePathsForDb = array_merge($attachUploadFilePathsForDb, ['ins_back' => $name]);
            $attachUploadFilePathsForEmail = array_merge($attachUploadFilePathsForEmail, ['ins_back' => public_path().'/'.$name]);
        }

        if (isset($requestIns['ins_document'])) {
            $file = $requestIns['ins_document'];

            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = $insPath.$name;

            //$storeFileName  = $this->uploadImage($insPath, $file);
            //array_push($attachUploadFilePaths, ['ins_document' => $storeFileName]);
            $attachUploadFilePathsForDb = array_merge($attachUploadFilePathsForDb, ['ins_document' => $name]);
            $attachUploadFilePathsForEmail = array_merge($attachUploadFilePathsForEmail, ['ins_document' => public_path().'/'.$name]);
        }

        //return $attachUploadFilePathsForDb;

        return [
            'for_email' => $attachUploadFilePathsForEmail,
            'for_db' => $attachUploadFilePathsForDb,
        ];
    }
}
