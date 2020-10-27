<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

trait ImageUpload
{
    public function imageUpload($file, $prefix) // Taking input image as parameter
    {
        // $destinationPath = '/uploads/'.$folder;


        // $file_name = time().'-'.$file->getClientOriginalName();

        // $image = Image::make($file);

        // $image->resize(1920, 1080, function ($constraint) {
        //       $constraint->aspectRatio();
        // })->save(public_path() . $destinationPath . $file_name);

        // $image->resize(350, 240, function ($constraint) {
        //       $constraint->aspectRatio();
        // })->save(public_path() . $destinationPath .'/thumbnails/'. $file_name);

        // return $file_name;


        //$image_name = str_random(6);
        //$ext = strtolower($file->getClientOriginalExtension()); // You can use also getClientOriginalName()
        $name = $file->getClientOriginalName();
        $image_full_name = $prefix.'/'.time().'_'.str_replace(' ', '', $name);
        Storage::put($image_full_name, file_get_contents($file), 'public');
        // $url = public_path('uploads/'.$image_full_name);
        return $image_full_name; // Just return image
    }

    private function getImageUrl($image) {
        return $url = Storage::url($image);
    }
}
