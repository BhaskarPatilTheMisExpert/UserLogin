<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;
use DB;

class ImageController extends Controller
{
    public function uploadImag()
    {
        return view('uploadImg.imgUpload');
    }

    public function imageUploadSave(Request $request)
    {
        $request->validate([
            'image' => 'required|image:jpeg,png|max:2048',
        ]);

        $folderName = time();
        $folderPath = public_path('images/' . $folderName);
        mkdir($folderPath, 0777, true);

        $imageName = time().'.'.$request->image->extension();

        $saveImage = $request->image->move(public_path('images/' . $folderName), $imageName);

        // small img
        $imageSmall = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        $imageSmall->fit(300, 300)->save(public_path('images/' . $folderName . '/s_' . $imageName));
        // dd($imageSmall);
        // mediun img
        $imageMedium = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        $imageMedium->fit(600, 600)->save(public_path('images/' . $folderName . '/m_' . $imageName));

        // lg image
        $imageLarge = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        $imageLarge->fit(1000, 1000)->save(public_path('images/' . $folderName . '/l_' . $imageName));

        // // Remove the original image
        // unlink(public_path('images/' . $folderName . '/' . $imageName));

         $saveData = \DB::table('images')->insert([
                'name' => $imageName, 
            ]);

        return response()->json(['success' => true, 'message' => 'Image uploaded successfully']);
    }

        public function showImg()
    {
        $images = DB::table('images')->get();
        // dd($images);
        return view('uploadImg.viewImage',compact('images'));
    }
}
