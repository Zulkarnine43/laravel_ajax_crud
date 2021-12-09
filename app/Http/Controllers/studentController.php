<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;

class studentController extends Controller
{
    //

    public function student_form()
    {
        return view('student.student');
    }

    public function StudentallData()
    {
        $data = student::orderBy('id','DESC')->get();
        return response()->json($data);
    }

    public function storeData(Request $request){

        $request->validate([
            'name' =>'required',
            'email' =>'required',
            'photo' =>'required',
        ]);

        $Image = $request->file('photo');
        if ($Image) {
            $currentTimeinSeconds = time();  
            $imageName =  $currentTimeinSeconds.'.'.$Image->getClientOriginalName();
            $directory = 'public/images/';
            $imageUrl = $directory.$imageName;
            
            $Image->move($directory, $imageName);
        }
          $data = student::insert([
              'name' =>$request->name,
              'email' =>$request->email,
              'photo' =>$imageUrl,
          ]);
          return response()->json('uploaded successfully');
      }
}
