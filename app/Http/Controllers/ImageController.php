<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use DB;
use App\Models\Images;
class ImageController extends Controller
{
    //
    public function uploadImag()
    {       
       // echo"upload funcction";
        return view('uploadImg.imgUpload');
    }
    public function imageUploadSave(Request $request)
    {
         $request->validate([
            'image' => 'required|image:jpeg,png|max:2048',
        ]);

        // $imageName = time().'.'.$request->image->extension();

        // $saveImage = $request->image->move(public_path('images'), $imageName);
        $folderName = time(); 
        $folderPath = public_path('images/' . $folderName);
        mkdir($folderPath, 0777, true); 

        $imageName = time().'.'.$request->image->extension(); 

        $saveImage = $request->image->move(public_path('images/' . $folderName), $imageName);

        // $saveImgDb = Images::create([
        //                 'name' => $imageName,
        //             ]);
        $saveData = \DB::table('images')->insert([
                'name' => $imageName, 
            ]);
        dd($saveData);
         
    }
}
