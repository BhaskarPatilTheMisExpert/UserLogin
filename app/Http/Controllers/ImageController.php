<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;
use DB;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    public function uploadImag()
    {
        return view('uploadImg.imgUpload');
    }

    public function imageUploadSave(Request $request)
    {
        $request->validate([
           'image' => 'required|image|mimes:jpeg,png|max:2048',
       ]);


        $folderName = Str::random(10);
        // dd($folderName);
        $folderPath = public_path('images/' . $folderName);
        mkdir($folderPath, 0777, true);

        $imageName = time().'.'.$request->image->extension();

        $saveImage = $request->image->move(public_path('images/' . $folderName), $imageName);

        // small img
        $imageSmall = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        // $imageSmall->fit(300, 300)->save(public_path('images/' . $folderName . '/s_' . $imageName));
        $imageSmall->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('images/' . $folderName . '/s_' . $imageName));
        // $imageSmall->resize(null, 300)->encode('jpg', 80)->save(public_path('images/' . $folderName . '/s_' . $imageName));


        // dd($imageSmall);
        // mediun img
        // $imageMedium = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        // $imageMedium->fit(600, 600)->save(public_path('images/' . $folderName . '/m_' . $imageName));

        $imageMedium = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        $imageMedium->resize(null, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/' . $folderName . '/m_' . $imageName));


        // lg image
        // $imageLarge = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        // $imageLarge->fit(1000, 1000)->save(public_path('images/' . $folderName . '/l_' . $imageName));

        $imageLarge = Image::make(public_path('images/' . $folderName . '/' . $imageName));
        $imageLarge->resize(null, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images/' . $folderName . '/l_' . $imageName));


         $saveData = \DB::table('images')->insert([
                'name' => $imageName,
                'folderName' => $folderName, 
            ]);
         // dd($saveData);
                if ($saveData) {
                    // echo "Image uploaded";
                    // return view('uploadImg.viewImage');
                    return redirect()->route('showImg');
                } else {
                    // Image not uploaded
                    echo "Image not uploaded";
                    return view('uploadImg.imgUpload');
                }
    }

        public function showImg()
    {
        $images = DB::table('images')->orderByDesc('created_at')->get();
        // dd($images);
        return view('uploadImg.viewImage',compact('images'));
    }

    public function viewImage(Request $request)
    {
         $imageUrl = $request->input('imageUrl');

         
         return response()->json('ramesh');
    }
}
