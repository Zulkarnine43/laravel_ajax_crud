<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     *
     * @return void
     */


    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
  public function ajax(){
      return view('teacher.index');
  }
  public function teacherAll()
  {
      $data = Role::orderBy('id','DESC')->get();
      return response()->json($data);
  }

  public function storeData(Request $request){

    $request->validate([
        'name' =>'required',
        'email' =>'required',
    ]);
      $data = Role::insert([
          'name' =>$request->name,
          'email' =>$request->email,
      ]);
      return response()->json($data);
  }
  public function DataEdit($id){

   $data = Role::findOrFail($id);
   return response()->json($data);
  }
  public function updateData(Request $request,$id){
    $request->validate([
        'name' =>'required',
        'email' =>'required',
    ]);
    $data = Role::findOrFail($id)->update([
        'name' =>$request->name,
        'email' =>$request->email,
    ]);
    return response()->json($data);

  }
  public function datetrData($id)
  {
    $data = Role::findOrFail($id)->delete();

    return response()->json($data);
  }
}
