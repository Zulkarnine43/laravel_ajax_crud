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
        return response()->json([
            'images'=>$data
        ]);
    }

    public function storeData(Request $request){
        $request->validate([
            'name' =>'required',
            'email' =>'required'
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

      public function DataEdit($id){
        $data = student::findOrFail($id);
        return response()->json($data);
       }

       public function updateData(Request $request){

        $Image = $request->file('photo');
        if ($Image) {
            $currentTimeinSeconds = time();  
            $imageName =  $currentTimeinSeconds.'.'.$Image->getClientOriginalName();
            $directory = 'public/images/';
            $imageUrl = $directory.$imageName;
            
            $Image->move($directory, $imageName);
        }
   
        $data = student::find($request->id);
        $data->name=$request->name;
        $data->email=$request->email;
        $data->photo=$imageUrl;
        $data->save();

        return response()->json($data);
    
      }
}
