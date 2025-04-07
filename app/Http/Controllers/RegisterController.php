<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
   public function view(){
    $data['title'] = 'Register';
    $data['exams'] = \App\Exam::all();
    $data['languages'] = \App\Language::all();
    $data['codes'] = \App\ActivationCode::where('school_id',Auth::user()->id)->where('is_used','0')->get();
    return view('admin.Register.register')->with($data);
   }
   public function edit($id){

      if(Auth::user()->type == 'admin'){
         $type = "school";
      }
      if(Auth::user()->type == 'school'){
         $type = "user";
      }
      $data['title'] = 'Register';
      $data['users'] = User::where('type',$type)->where('id',$id)->first();
      $data['codes'] = \App\ActivationCode::where('school_id',$id)->get();
      $data['exams'] = \App\Exam::all();
      $data['languages'] = \App\Language::all();
    return view('admin.Register.edit')->with($data);

   }
   public function list(){
      if(Auth::user()->type == 'admin'){
         $type = "school";
      }
      if(Auth::user()->type == 'school'){
         $type = "user";
      }
      $data['title'] = 'Register';
      $data['users'] = User::where('type',$type)->where('parent_id',Auth::user()->id)->paginate(20);
      return view('admin.Register.index')->with($data);
   }
   public function userList(){
      $data['title'] = 'User List';
      $data['users'] = User::where('type','user')->paginate(20);
      return view('admin.Register.user-list')->with($data);
   }

   public function index(Request $request)
   {
      if($request->ajax()) {
         $data = \App\User::where('type','user')->with(['parent', 'Language']);
         return Datatables::of($data)
               ->addIndexColumn()
               ->filterColumn('parent.school_name',function($query, $keyword) {
                     $query->whereHas('parent',function ($query1) use ($keyword) {
                        $query1->where('school_name', 'like', "%" . $keyword . "%");
            });
         })
         ->editColumn('created_at',function($row){
            return date($row->created_at->format('Y-m-d'));
         })
		->editColumn('mac_address',function($row){
            if($row->mac_address == null) {
               return null;
            }
            else {
               return substr($row->mac_address,0,8)." **** ****";
            }
         })
         ->make(true);
      }
      return view('admin.Register.user-list');
   }

   public function store(Request $request){

      if(Auth::user()->type == 'school'){
         $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            // 'email' => 'unique:users',
            'phone' => 'required',
            'gender'=> 'required',
            'dob'   => 'required',
            'activation_code' => 'required',
            // 'exam' => 'required',
            'language' => 'required',
            'type_of_driving_license' => 'required',
            'profession_of_the_trainee' => 'required',
         ]);
         
         $expiry_date = Carbon::now()->addWeeks(8);

         $data = array(
            "parent_id" => Auth::user()->id,
            "fname" => $request->fname,
            "lname" => $request->lname,
            "email" => uniqid()."@gmail.com",
            "phone" => $request->phone,
            "name_of_registrator" => $request->name_of_registrator ,
            "gender" => $request->gender,
            "dob" => $request->dob,
            "token" => $request->activation_code,
            "expiry_date" => $expiry_date,
            "language_id" => $request->language,
            "type" => 'user',
            "type_of_driving_license" => $request->type_of_driving_license,
            "profession_of_the_trainee" => $request->profession_of_the_trainee,
         );
         $user = User::create($data);
         ActivationCode::where('activation_code',$request->activation_code)->update(['is_used' => '1']);
         
         // Mail::send('mail.registermail', ['token' => $request->activation_code, 'message', $this], function ($m) use ($user) {
         //    $m->to($user->email)->subject("Activation Code");
         // });

      }
      if(Auth::user()->type == 'admin'){
         $this->validate($request, [
            'school_name' => 'required',
            'email' => 'required',
            'password'=> 'required',
            'phone' => 'required',
            // 'activation_code' => 'required',
         ]);

         $data = array(
            "parent_id" => Auth::user()->id,
            "school_name" => $request->school_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "type" => 'school',
         );
         // dd($data);
         $user = User::create($data);

      //    $activation_codes = $request->activation_code;
      //    $generate_codes = \App\Helpers\General\ActivationCodeGenerate::generateCode($user->id,$activation_codes);

      //   foreach($generate_codes as $activation_code){
      //       $data = array(
      //          "school_id" => $user->id,
      //          "activation_code" => $activation_code,
      //       );
      //       ActivationCode::create($data);
      //   }
      }
      return redirect()->route('list')->with('s', 'Success'); 
   }

   public function update(Request $request){

      if(Auth::user()->type == 'school'){
         $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'unique:users',
            'phone' => 'required',
            'gender'=> 'required',
            'dob'   => 'required',
            // 'activation_code' => 'required',
            // 'exam' => 'required',
            'language' => 'required',
            'type_of_driving_license' => 'required',
            'profession_of_the_trainee' => 'required',
         ]);

         $data = array(
            "fname" => $request->fname,
            "lname" => $request->lname,
            "email" => $request->email,
            "phone" => $request->phone,
            "name_of_registrator" => $request->name_of_registrator,
            "gender" => $request->gender,
            "dob" => $request->dob,
            // "token" => $request->activation_code,
            // "exam_id" => $request->exam,
            "language_id" => $request->language,
            "type" => 'user',
            "type_of_driving_license" => $request->type_of_driving_license,
            "profession_of_the_trainee" => $request->profession_of_the_trainee,
         );
         $user = User::where('id',$request->id)->update($data);;
      }
      if(Auth::user()->type == 'admin'){
         $this->validate($request, [
            'school_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
         ]);

         $data = array(
            "school_name" => $request->school_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "type" => 'school',
         );
         $user = User::where('id',$request->id)->update($data);
      }
      return redirect()->route('list')->with('s', 'Success'); 
      
   }

   public function checkEmail(Request $request){
      $user = User::where('email',$request->email)->first();
      if(!$user){
         return response()->json(['status' => false,'message' => "User not found"]);
      }else{

         if($user->type == 'admin'){
            return response()->json(['status' => true,'data' => $user ]);
         }
         else{
            return response()->json(['status' => false,'message' => 'Password can not be change' ]);
         }
      }
   }

   public function destroy($id){
      $user = User::where('id',$id)->delete();
      return redirect()->route('list'); 
   }
}

