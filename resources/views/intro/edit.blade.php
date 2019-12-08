<form id="formData" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="title">제목 : </label>
        </label><input type="text" name="title" id="title" class="form-control" value="{{$intro->title}}">
    </div>
    <div class="form-group">
       <label for="place">장소 : </label>
        <input type="text" name="place" id="place" class="form-control" value="{{$intro->place}}">
    </div>
    <div class="form-group">
        <label for="master">담당자 : </label>
        <input type="text" name="master" id="master" class="form-control" value="{{$intro->master}}">
    </div>
    <div class="form-group">
    <label for="weekset">요일 : </label>
        <div class='select_bar' id='weekset'>
        </div>
    </div>
    <div class="form-group">
        <label for="starttime">시작시간 : </label>
        <input type="time" name="starttime" id="starttime" class="form-control" value="{{$intro->starttime}}">
    </div>
    <div class="form-group">
        <label for="endtime">종료시간 : </label>
        <input type="time" name="endtime" id="endtime" class="form-control" value="{{$intro->endtime}}">
    </div>
    <div class="form-group">
        <textarea name="append" cols="30" rows="10" id="title" class="form-control" placeholder="세부사항">{{$intro->append}}</textarea>
    </div>
    <div class="form-group">
        <label for="photo">사진 : </label>
        <input type="file" name="photo" id="photo">
        <span class='img_section'></span>
    </div>
    <div class='btnBlk'>
        @if($lv)
        <button type="submit" class="modBtn btn btn-primary"> 수정하기 </button>
        @endif
        <button type="button" class="clsBtn btn btn-primary">닫기</button>
    </div>
</form>

<script>
    var weekset = '';
    var select = $('#weekset');
    var key = "{{$intro->weekset}}";
    for(i = 0; i<7; i++){
        var l = i + 1;
        var option = $(`<button type="button" data-value="${l}" class='selec_off'>${weeknd[i]}</button>`);
        if( key.indexOf(l) != -1){ // 문자열 찾기
            option = $(`<button type="button" data-value="${l}" class='selec_on'>${weeknd[i]}</button>`);
            weekset += l;
        }
        select.append(option);
    }
    $('.select_bar > button').on('click',function(){
        var val = $(this).attr('data-value');
        if($(this).hasClass("selec_off")){
            $(this).removeClass('selec_off');
            $(this).addClass('selec_on');
            weekset += val;
        }else{
            $(this).removeClass('selec_on');
            $(this).addClass('selec_off');
            weekset = weekset.replace(val,'');
        }
    });
    $('.clsBtn').on('click',function(e){
        load_page({{$intro->id}});
    });
    $('.modBtn').on('click',function(e){
        e.preventDefault();
        // Get form
        var form = $('#formData')[0];
        // Create an FormData object 
        var data = new FormData(form);
        data.append('weekset',weekset);
        data.append('_method', 'PATCH');
        if(valid_chk(data)){
            $.ajax({
                type:'POST',
                url: '/intros/' + {{$intro->id}},
                data:data,
                processData:false,
                contentType:false,
                cache:false,
                success : function(data){
                    alert(data["message"]);
                    if(data["status"]) load_page({{$intro->id}});
                }
            });
        }
    });
    $("#photo").change(function(){
        readURL(this);
    });
</script>
<style>
    .select_bar button { padding:15px 20px; font:bold 12px malgun gothic; }
    .select_bar .selec_off {background:#bbbbbb; color:#444444; border:solid 2px #dddddd; }
    .select_bar .selec_on {background:#0069d9; color:white; border:solid 2px #007bff;}
</style>