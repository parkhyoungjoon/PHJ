<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return redirect("/profile"."/".auth()->user()->user_id); 
    }


    public function show($id)
    {
        // if(!auth()->check()){
        //     return redirect('/login');
        // }
        if($id != auth()->user()->user_id){
            return redirect("/profile"."/".auth()->user()->user_id); 
            # 나누기 연산으로 착각함.. 0 / a  로  인식해서 오류 발생. 따라서 /profile  /  따로 
        }

        $user_info = \App\User::where('user_id',$id)->first();
        $user_questions = \App\Question::where('user_id',auth()->user()->id)->latest()->paginate(5);
        $user_q_a_num = [];
        foreach($user_questions as $question){
            $user_q_a_num[$question->id] = $question->answers()->count();
        }        

        if($user_info->admin == 1){
            $users = \App\User::get();
            return view("profile.index",compact('user_info','user_questions','user_q_a_num','users'));
        }else{
            return view("profile.index",compact('user_info','user_questions','user_q_a_num'));
        }
        
        
    }

    # 정보 변경 ( 비밀번호 미포함 )
    public function edit_info($id)
    {
        
        $info = \App\User::where('user_id',$id)->first();
        return view('profile.edit_info',compact('info'));

    }
    public function update_info(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'email' => 'required|max:255',
            'phone' =>'required|max:255',
            'birth' =>'required|max:255',      
        ]);
        
        $validator->validate();
        
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
            ], 200);
        }

        # $request->all() 써도 됨.
        $user = \App\User::find(auth()->user()->id)->update([
            'name' => $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'birth'=> $request->birth,
        ]);
        
        return redirect('/profile');

    }

    public function edit_pwd($id)
    {
        //
        return view('profile.edit_pwd');
    }
    public function update_pwd(Request $request, $id) # 유저 패스워드 변경
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);
        $validator->validate();
        
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
            ], 200);
        }
        $password = Hash::make($request->password);

        $user = \App\User::find(auth()->user()->id)->update([
            'password' => $password,
        ]);
        return redirect('/profile'); 
    }


    public function destroy($id) # 관리자가 유저 아이디 삭제
    {
        if(auth()->user()->id == $id){
            $message['message'] = "자신의 계정을 삭제할 수 없습니다.";
            return $message;
        }
        if(auth()->user()->admin ==0 ){
            return redirect('/');
        }
        \App\User::where('id',$id)->delete();
        $users = \App\User::get();
        return $users;
    }
    public function put_admin($id) # 관리자가 유저에게 관리자 권한 부여
    {   
        if(auth()->user()->id == $id){
            $message['message'] = "자신의 권한은 관리할 수 없습니다.";
            return $message;
        }

        if(auth()->user()->admin ==0 ){
            return redirect('/');
        }
        if(\App\User::where('id',$id)->first()->admin){
            \App\User::where('id',$id)->update(['admin'=>0]);
        }else{            
            \App\User::where('id',$id)->update(['admin'=>1]);
        }
        $users = \App\User::get();
        return $users;
        
    }
}
