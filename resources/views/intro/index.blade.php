@extends('layouts.intros')
@section('content')
    <div class='btmBlk'></div>
    <div class='topBlk'>
   
    </div>
    <button class='addBtn'>글쓰기</button>
    
@stop
@section('script')
    <script>
        function intro_modify(id){
            $('.btmBlk').load('/intros/'+id+'/edit');
        }
        $('.addBtn').on('click',function(e){
            $('.btmBlk').load('/intros/create');
        });
        function intro_delete(id){
            if(confirm('글을 삭제합니다.')){
                $.ajax({
                    type: 'DELETE',
                    url: '/intros/' + id,
                }).then(function(){
                    get_list();
                });
            }
        }
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        function get_list(){
            console.log('실행이요 이요이요이ㅛ요용어여어ㅓ');
            $.ajax({
                method:'GET',
                url: '/intros/list',
                })
                .done(function( board_list ) {
                    var board_div= $('.topBlk');
                    board_div.html('');
                    board_list.map(board=>{
                        var c_ul = $('<ul>');
                        var li = $('<li>'+ board.title +'</li>');
                        li.append($('<li>'+ board.place +'</li>'));
                        li.append($('<li>'+ board.master +'</li>'));
                        li.append($('<li>'+ board.weekset +'</li>'));
                        li.append($('<li>'+ board.starttime +'</li>'));
                        li.append($('<li>'+ board.endtime +'</li>'));
                        li.append($('<li>'+ board.append +'</li>'));
                        li.append($(`<li><img src = "/images/${board.photo}" alt="${board.title}" width="200"/> </li>`));
                        c_ul.append(li);
                        var button = $(`<li><button type="button">수정하기</button></li>`);
                        button.bind('click' , function(e) {intro_modify(board.id)});
                        c_ul.append(button);
                        var button = $(`<li><button type="button">삭제하기</button></li>`);
                        button.bind('click' , function(e) {intro_delete(board.id)});
                        c_ul.append(button);
                        board_div.append(c_ul);
                    });
                });
        }
        get_list();
    </script>
@stop