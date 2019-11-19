<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\IntrosRequest;
use \App\Intro;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IntroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intros = Intro::all();
        return view('intro.index');
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intro.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntrosRequest $request)
    {
        $weekset = 0;
        $count = count($request->weekset);
        for($i = 0; $i < $count; $i++){ 
            $weekset .= $request->weekset[$i];
        }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::random(15).filter_var($photo->getClientOriginalName(),FILTER_SANITIZE_URL);
            // 중복방지를 위해 랜덤문자열 + filter_var(첫번째 인자값의 내용중 두번째인자 필터를 이용해서 필터링)
            // getClientOriginalName : 기존 파일이름,  FILTER_SANITIZE_URL : URL로 부적절한 이름 필터링
            $photo->move(attachements_path(),$filename);
            // 파일을 원하는 위치로 옮기는 구문
        }
        $intro = Intro::create([
            'title' => $request->title,
            'append' => $request->append,
            'place' => $request->place,
            'master' => $request->master,
            'weekset' => $weekset,
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'photo' => isset($filename) ? $filename : '',
        ]); // Model Intro를 이용해서 데이터 생성, 생성되면 데이터로 객체 생성
        /*
        if(!$intro){
            return back()->with('flash_message','글이 저장되지 않았습니다.')->withInput();
            // with : 인자1[키], 인자2[값]을 세션에 저장 사용자에게 피드백을 제공하기 위해 존재
        }
        return redirect(route('intros.index'))->with('flash_message','작성하신 글이 저장되었습니다.');
        */
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $intro = Intro::where('id', $id)->first();
        return view('intro.edit',['intro'=>$intro]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IntrosRequest $request, $id)
    {
        $weekset = 0;
        $count = count($request->weekset);
        for($i = 0; $i < $count; $i++){ 
            $weekset .= $request->weekset[$i];
        }
        $oldPhoto = Intro::where('id','=', $id)->first();
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::random(15).filter_var($photo->getClientOriginalName(),FILTER_SANITIZE_URL);
            $photo->move(attachements_path(),$filename);
            unlink(storage_path('../public/images/'.$oldPhoto->photo)); // 기존파일 삭제
            //unlink : 파일삭제 storage_path: 주어진 파일의 절대경로 반환
        }
        $intro = Intro::where('id', $id)->update([
            'title' => $request->title,
            'append' => $request->append,
            'place' => $request->place,
            'master' => $request->master,
            'weekset' => $weekset,
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'photo' => isset($filename) ? $filename : $oldPhoto->photo,
        ]);
        //if(!$intro){
            //return back()->with('flash_message','글이 저장되지 않았습니다.')->withInput();
            // with : 인자1[키], 인자2[값]을 세션에 저장 사용자에게 피드백을 제공하기 위해 존재
        //}
        //return redirect(route('intros.index'))->with('flash_message','작성하신 글이 저장되었습니다.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Intro::where('id', $id)->delete();
        return response()->json([],204);
    }
}
