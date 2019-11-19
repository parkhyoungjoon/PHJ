<?php
    function attachements_path($path=''){
        return public_path('images'.($path ? DIRECTORY_SEPARATOR.$path : $path));
        //public_pth : 우리 프로젝트의 웹 서버 루트 디렉터리의 절대 경로를 반환하는 함수
    }
?>