var weeknd = [ '월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일' ];
var attrs = ['title', 'place', 'master', 'weekset', 'starttime', 'endtime', 'append',]
var attrKo = {
    'title' : '제목',
    'place' : '장소',
    'master' : '담당자',
    'weekset' : '요일',
    'starttime' : '시작시간',
    'endtime' : '종료시간',
    'append' : '내용',
};
function load_page(id,str = ''){
    $('.page').load('/intros/'+id+str);
}
function get_list(lv){
    var board_div= $('.page');
    board_div.html('');
    var b_ul = $('<ul class="b_ul">');
    for(i = 9; i <= 18; i++){
        var ti = (`<li>${i}시 --</li>`);
        b_ul.append(ti); 
    }
    board_div.append(b_ul);
    $.ajax({
        method:'GET',
        url: '/intros/list',
        })
        .done(function( board_list ) {
            var key = 0;
            board_list.map(board=>{
                var a_ul = $('<ul class="a_ul">');
                var c_ul = $('<ul>');
                a_ul.append(c_ul); 
                var li = $('<li> ' + weeknd[key] + ' </li>');
                c_ul.append(li); 
                board.map(list=>{
                    var str = '';
                    var time = parseInt(list.endtime) - parseInt(list.starttime);
                    var y_fix = (parseInt(list.starttime)-9)*60+40;
                    var c_ul = $(`<li style="height:${(time*60)}px; top:${y_fix}px"><div>${list.title}</div></li>`);
                    c_ul.bind('click' , function(e) {load_page(list.id)});
                    a_ul.append(c_ul); 
                });
                board_div.append(a_ul);
                key++;
            });
            if(lv){
            var button = $(`<div class='form-group'><button type="button" class="btn btn-primary">등록하기</button></div>`);
            button.bind('click' , function(e) {load_page('create')});
            board_div.append(button);
            }
        });
}
function valid_chk(data){
    var err = 0;
    var filter = '';
    var txt = '[ ';
    attrs.map(function(attr){
        if (data.get(attr) === filter){
            $(`#${attr}`).css('background','#FAECC5');
            $(`#${attr}`).css('border','solid 1px #FFBB00');
            txt += attrKo[attr] + ' ';
            err++;
        }else{
            $(`#${attr}`).css('background',(attr == 'weekset') ? 'none' : 'white');
            $(`#${attr}`).css('border',(attr == 'weekset') ? 'none' : 'solid 1px black');
        }
    });
    txt += '] 입력해주세요';
    if(err !== 0) alert(txt);
    return (err === 0) ? true : false;
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {      
            $('.img_section').html('');
            var i = imageResize(e.target.result);
            $('.img_section').append(i);
            
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function imageResize(img_src){
    var i = new Image(); 
    i.src = img_src;
    if(i.width > i.height) i.width = 200;
    else i.height = 200;
    return i;
}

