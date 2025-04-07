<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\View;

class ActivationCodeController extends Controller
{
    public function list(){
        $data['title'] = 'Activation Code List';
        $data['codes'] = \App\ActivationCode::with('User')->get();
        return view('admin.activationCode.index')->with($data);
    }

    public function view(){
        $data['title'] = 'Add Activation Code';
        $data['schools'] = \App\User::where('type','school')->get();
        return view('admin.activationCode.view')->with($data);
    
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = \App\ActivationCode::whereHas('User')->with('User');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('student_name',function($row){
                        $student_name = User::where('token',$row->activation_code)->first();
                        $fname = $student_name->fname ?? '-';
                        $lname = $student_name->lname ?? ' ';
                        return ($fname.' '.$lname) ?? '-';
                    })
                    ->addColumn('action', function($row){
     
                        // $btn = View::make('admin.activationCode.action',['row' => $row])->render();
                        $btn = '';
                        if($row->is_used == 1 && $row->is_prolonged == 0){
                            $btn = '<button onClick="prolongCode('.$row->activation_code.')" class="btn btn-sm btn-primary">Prolong Code</button>';  
                        }
                        return $btn;
                    })
                    ->editColumn('user.created_at',function($row){
                        $start_date = User::where('token',$row->activation_code)->value('created_at');
                        $Start_date = $start_date ? date($start_date->format('Y-m-d')) : '-';
                        return $Start_date;
                     })
                    ->editColumn('user.expiry_date',function($row){
                        // dd($row->User);
                        $ex_date = User::where('token',$row->activation_code)->value('expiry_date');
                        return $ex_date ?? '-';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.activationCode.index');
    }

    public function edit($id){
        $data['title'] = 'Activation Code';
        $data['schools'] = \App\ActivationCode::where('id',$id)->with('User')->get();
        $data['code'] = \App\ActivationCode::where('id',$id)->with('User')->first();
        return view('admin.activationCode.edit')->with($data);
    }

    public function store(Request $request){
        // dd(explode(",",$request->activation_code));
        $this->validate($request, [
           'school_id' => 'required',
           'activation_code' => 'required',
        ]);
        
        // $activation_codes = explode(",",$request->activation_code);
        $activation_codes = $request->activation_code;

        $generate_codes = \App\Helpers\General\ActivationCodeGenerate::generateCode($request->school_id,$activation_codes);

        foreach($generate_codes as $activation_code){
            $data = array(
               "school_id" => $request->school_id,
               "activation_code" => $activation_code,
            );
            ActivationCode::create($data);
        }
  
        return redirect()->route('code_list')->with('s', 'Success'); 
    }

    public function update(Request $request){
        
        $this->validate($request, [
           'school_id' => 'required',
           'activation_code' => 'required',
        ]);
        
        $data = array(
           "school_id" => $request->school_id,
           "activation_code" => $request->activation_code,
        );
        ActivationCode::where('id',$request->id)->update($data);
  
        return redirect()->route('code_list')->with('s', 'Success'); 
    }
    public function destroy($id){
        ActivationCode::where('id',$id)->delete();
        return redirect()->route('code_list')->with('s', 'Success'); 
    }

    public function prolong_code(Request $request){

        $expity_date  = User::where('token',$request->code)->value('expiry_date');
        $newExpiryDate = Carbon::createFromFormat('Y-m-d',$expity_date)->addMonths(1);
        User::where('token',$request->code)->update(['expiry_date'=>$newExpiryDate]);
        ActivationCode::where('activation_code',$request->code)->update(['is_prolonged'=>'1']);
        return response()->json(['status'=>true,'message'=>'Success']);

    }

}
