<?php
    function attachements_path($path=''){

        return public_path('images'.($path ? DIRECTORY_SEPARATOR.$path : $path));

        //public_pth : 우리 프로젝트의 웹 서버 루트 디렉터리의 절대 경로를 반환하는 함수

    }

    ##  composer.json  autoload  에  "files": ["app/helper.php"] 추가 후.

    ##  composer dump-autoload --optimize

    function time_check($time){

        $timecut = substr($time,0,2); //문자열 앞에서 2개(시간)만 출력

        if($timecut == '00') $time = substr_replace($time, '12', 0,2);

        if($timecut == '12') $time = substr_replace($time, '00', 0,2);

        // 오전 12시의 값과 오후 12시의 값 바꾸기

        return $time;

    }

    function week_check($request,$id = -1){

        $starttime = str_replace(':','',$request->starttime);
        $endtime = str_replace(':','',$request->endtime);
        $starttime = substr($starttime, 0, 4);
        $endtime = substr($endtime, 0, 4);

        if($starttime > $endtime){

            return ['message'=>'시작시간이 종료시간보다 빨라야합니다.','status'=>false];

        }

        if($starttime < 900 || $starttime > 1800 || $endtime < 900 || $endtime > 1800){

            return ['message'=>'시간은 09시부터 12시까지 가능합니다.','status'=>false];

        }

        $weekset = $request->weekset;

        $count = strlen($weekset);

        for($i = 0; $i < $count; $i++){

            $key = substr($weekset, $i,1);

            $dateData = \App\Intro::where('weekset','like', '%'.$key.'%')->Where('id', '!=' , $id)->get();

            foreach($dateData as $data){
                $oldstart = str_replace(':','',$data->starttime);
                $oldend = str_replace(':','',$data->endtime);
                $oldstart = substr($data->starttime, 0, 4);
                $oldend = substr($data->endtime, 0, 4);
                
                if($starttime == $oldstart || ($starttime > $oldstart && $starttime < $oldend) || ($starttime < $oldstart && $endtime > $oldstart)) { 

                    return ['message'=>'이미 존재하는 시간표 입니다.','status'=>false];

                }

            }

        }

        return ['message'=>$weekset,'status'=>true];

    }



    # Q&A

    function return_user_name($answers){# 데이터를 받고 , 기존 데이터에  데이터를 작성한 유저의 이름을 반환.

        

        $data = $answers;

        $count = 0;

        

        foreach($answers as $answer){

            $data[$count]['u_name']=\App\User::find($answer->user_id)->user_id;

            $count ++;

        }



        return $data;

    }
?>
