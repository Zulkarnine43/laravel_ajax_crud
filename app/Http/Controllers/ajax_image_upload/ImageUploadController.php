<?php
 
namespace App\Http\Controllers\ajax_image_upload;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use App\Models\Photo;
 
class ImageUploadController extends Controller
{
    //
    public function index()
    {
        return view('ajax_image_upload.index');
    }
 
    public function store(Request $request)
    {
       request()->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);
       if ($files = $request->file('profile_image')) {
       // Define upload path
           $destinationPath = public_path('/profile_images/'); // upload path
 // Upload Orginal Image           
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
 
           $insert['image'] = "$profileImage";
        // Save In Database
            $imagemodel= new Photo();
            $imagemodel->photo_name="$profileImage";
            $imagemodel->save();
        }
        
        $image = Photo::latest()->first(['photo_name']);
        return Response()->json($image);
    }
 
}