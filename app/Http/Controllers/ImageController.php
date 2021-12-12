<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
      return view('images');
    }

    public function fetchImage()
    {
      $images = Image::all();
      return response()->json([
        'images'=>$images
      ]);
    }
    public function storeImage(Request $request)
    {
        $request->validate([
          'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = new Image;

        if ($request->file('file')) {
            $imagePath = $request->file('file');
            $imageName = $imagePath->getClientOriginalName();

            $path = $request->file('file')->storeAs('uploads', $imageName, 'public');
        }

        $image->name = $imageName;
        $image->image = '/storage/'.$path;
        $image->name = $request->name;
        $image->email = $request->email;
        $image->department = $request->department;
        $image->save();

        return response()->json($image);
    }

    public function editImage($id)
    {
        $images = Image::find($id);
        return response()->json($images);
    }
    public function updateImage(Request $request)
    {
      // $request->validate([
      //   'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      // ]);


      $image = Image::find($request->image_id);

      if ($request->file('file')) {
        $imagePath = $request->file('file');
        $imageName = $imagePath->getClientOriginalName();

        $path = $request->file('file')->storeAs('uploads', $imageName, 'public');
    }

      

      $image->name = $imageName;
      $image->image = '/storage/'.$path;
      $image->name = $request->name;
      $image->email = $request->email;
      $image->department = $request->department;
      $image->save();

      return response()->json($image);
    }

    function deleteImage($id)
    {
       $images = Image::find($id)->delete();
       return response()->json($images);
    }
} 